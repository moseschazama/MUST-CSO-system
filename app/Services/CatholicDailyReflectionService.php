<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CatholicDailyReflectionService
{
    public const TIMEZONE = 'Africa/Blantyre';
    public const FEED_URL = 'https://catholic-daily-reflections.com/feed/';
    public const UNAVAILABLE_TODAY = "Today's reflection is not yet available. Please check back soon.";

    public function today(): array
    {
        return $this->get($this->todayDateString());
    }

    public function get(?string $date = null): array
    {
        $date = $this->normalizeDate($date) ?? $this->todayDateString();
        $isToday = $date === $this->todayDateString();
        $ttl = $isToday ? now()->addMinutes(20) : now()->addDays(30);

        $resolved = Cache::remember("daily_reflection.date.{$date}", $ttl, function () use ($date) {
            return $this->resolveForDate($date);
        });

        if (! $resolved) {
            if ($isToday) {
                Cache::put("daily_reflection.date.{$date}", null, now()->addMinutes(5));
            }
            $mapped = $this->mappedReflection($date);
            if ($mapped) {
                $resolved = $mapped;
                Cache::put("daily_reflection.date.{$date}", $resolved, $ttl);
            }
        }

        return $this->present($date, $resolved);
    }

    public function todayDateString(): string
    {
        return Carbon::now(self::TIMEZONE)->toDateString();
    }

    public function normalizeDate(?string $date): ?string
    {
        if (! is_string($date) || trim($date) === '') {
            return null;
        }

        try {
            $parsed = Carbon::createFromFormat('Y-m-d', trim($date), self::TIMEZONE);
            if ($parsed === false || $parsed->format('Y-m-d') !== trim($date)) {
                return null;
            }

            return $parsed->toDateString();
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function recentHistory(int $days = 10): array
    {
        $history = [];
        $start = Carbon::now(self::TIMEZONE)->startOfDay();

        for ($i = 1; $i <= $days; $i++) {
            $date = $start->copy()->subDays($i)->toDateString();
            $history[] = $this->get($date);
        }

        return $history;
    }

    public function present(string $date, ?array $reflection): array
    {
        $date = $this->normalizeDate($date) ?? $this->todayDateString();
        $label = Carbon::createFromFormat('Y-m-d', $date, self::TIMEZONE)->format('l, j F Y');

        if (! $reflection) {
            return [
                'date' => $date,
                'date_label' => $label,
                'found' => false,
                'message' => $date === $this->todayDateString()
                    ? self::UNAVAILABLE_TODAY
                    : 'The reflection for this date is not yet available.',
                'reflection' => null,
            ];
        }

        $reflection['date'] = $date;
        $reflection['date_label'] = $reflection['date_label'] ?? $label;

        return [
            'date' => $date,
            'date_label' => $reflection['date_label'],
            'found' => true,
            'message' => null,
            'reflection' => $reflection,
        ];
    }

    protected function resolveForDate(string $date): ?array
    {
        $mapped = $this->mappedReflection($date);
        if ($mapped) {
            return $mapped;
        }

        $items = $this->fetchFeedItems();
        foreach ($items as $item) {
            foreach ($this->extractIntendedDates($item) as $itemDate) {
                $this->rememberMapping($itemDate, $item);
            }
        }

        return $this->mappedReflection($date);
    }

    protected function fetchFeedItems(): array
    {
        return Cache::remember('daily_reflection.feed_items', now()->addMinutes(20), function () {
            try {
                $body = $this->fetchFeedBody();
                if ($body === null) {
                    return [];
                }

                $xml = @simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);
                if ($xml === false || ! isset($xml->channel->item)) {
                    Log::notice('DailyReflection: feed parse failed.');

                    return [];
                }

                $items = [];
                foreach ($xml->channel->item as $entry) {
                    $parsed = $this->parseItem($entry);
                    if ($parsed) {
                        $items[] = $parsed;
                    }
                }

                return $items;
            } catch (\Throwable $e) {
                Log::notice('DailyReflection: feed fetch error.', ['error' => $e->getMessage()]);

                return [];
            }
        });
    }

    protected function fetchFeedBody(): ?string
    {
        $headers = [
            'User-Agent' => 'MUST-CSO/1.0 (+'.config('app.url').')',
            'Accept' => 'application/rss+xml, application/xml, text/xml;q=0.9, */*;q=0.8',
        ];

        try {
            $response = Http::timeout(12)->withHeaders($headers)->get(self::FEED_URL);
            if ($response->successful()) {
                return $response->body();
            }

            Log::notice('DailyReflection: feed request failed.', ['status' => $response->status()]);
        } catch (\Throwable $e) {
            Log::notice('DailyReflection: feed request error.', ['error' => $e->getMessage()]);
        }

        // Retry without certificate verification for environments missing a CA bundle.
        try {
            $response = Http::withoutVerifying()->timeout(12)->withHeaders($headers)->get(self::FEED_URL);
            if ($response->successful()) {
                return $response->body();
            }

            Log::notice('DailyReflection: feed request failed (insecure fallback).', ['status' => $response->status()]);
        } catch (\Throwable $e) {
            Log::notice('DailyReflection: feed request error (insecure fallback).', ['error' => $e->getMessage()]);
        }

        return null;
    }

    protected function parseItem(\SimpleXMLElement $entry): ?array
    {
        $title = trim((string) $entry->title);
        $link = trim((string) $entry->link);
        $description = trim((string) $entry->description);

        $content = '';
        $contentNode = $entry->children('content', true);
        if ($contentNode && isset($contentNode->encoded)) {
            $content = (string) $contentNode->encoded;
        }
        if ($content === '') {
            $content = $description;
        }

        if ($title === '' || $content === '') {
            return null;
        }

        $plain = $this->plainText($content);
        $liturgicalDay = $this->extractLiturgicalDay($content, $plain);

        return [
            'title' => html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
            'url' => $link,
            'content_html' => $this->sanitizeContentHtml($content),
            'excerpt' => $this->extractExcerpt($plain, $liturgicalDay),
            'liturgical_day' => $liturgicalDay,
            'image' => $this->extractImage($content),
            'source' => 'Catholic Daily Reflections',
        ];
    }

    protected function extractIntendedDates(array $item): array
    {
        $haystacks = [
            (string) ($item['liturgical_day'] ?? ''),
            Str::limit(strip_tags((string) ($item['content_html'] ?? '')), 1200, ''),
            (string) ($item['title'] ?? ''),
        ];

        $dates = [];
        foreach ($haystacks as $text) {
            foreach ($this->findDatesInText($text) as $date) {
                $dates[$date] = true;
            }
            if (! empty($dates)) {
                break;
            }
        }

        return array_keys($dates);
    }

    protected function findDatesInText(string $text): array
    {
        $text = trim(preg_replace('/\s+/', ' ', html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8')) ?? $text);
        if ($text === '') {
            return [];
        }

        $results = [];
        $patterns = [
            '/\b(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),?\s+(\d{4})\b/i',
            '/\b(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Sept|Oct|Nov|Dec)\.?\s+(\d{1,2}),?\s+(\d{4})\b/i',
            '/\b(\d{4})-(\d{2})-(\d{2})\b/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match_all($pattern, $text, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $date = $this->parseMatchToDate($match[0]);
                    if ($date) {
                        $results[$date] = true;
                    }
                }
            }
        }

        return array_keys($results);
    }

    protected function parseMatchToDate(string $raw): ?string
    {
        try {
            $raw = preg_replace('/\bSept\.?\b/i', 'Sep', trim($raw)) ?? trim($raw);
            $formats = ['F j, Y', 'F j Y', 'M j, Y', 'M j Y', 'Y-m-d'];
            foreach ($formats as $format) {
                $dt = Carbon::createFromFormat('!'.$format, $raw, self::TIMEZONE);
                if ($dt !== false) {
                    $errors = Carbon::getLastErrors();
                    if (is_array($errors) && (($errors['warning_count'] ?? 0) > 0 || ($errors['error_count'] ?? 0) > 0)) {
                        continue;
                    }

                    return $dt->toDateString();
                }
            }
        } catch (\Throwable $e) {
            return null;
        }

        return null;
    }

    protected function extractLiturgicalDay(string $html, string $plain): ?string
    {
        if (preg_match('/\b(?:January|February|March|April|May|June|July|August|September|October|November|December)\s+\d{1,2},\s+\d{4}[^A-Za-z0-9]*(?:Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday)?[^.:\n\r]*(?:Week|Sunday|Solemnity|Feast|Memorial|Season|Advent|Lent|Easter|Christmas|Ordinary Time|Octave)?[^.:\n\r]*/iu', $plain, $m)) {
            $line = trim(preg_replace('/\s+/', ' ', $m[0]) ?? $m[0], " \t\n\r\0\x0B-–—");
            if ($line !== '' && mb_strlen($line) <= 180) {
                return $line;
            }
        }

        if (preg_match('/<strong[^>]*>\s*<em[^>]*>(.*?)<\/em>\s*<\/strong>/is', $html, $m)) {
            $line = trim(preg_replace('/\s+/', ' ', strip_tags($m[1])) ?? '');
            if ($line !== '' && mb_strlen($line) <= 180) {
                return $line;
            }
        }

        return null;
    }

    protected function extractExcerpt(string $plain, ?string $liturgicalDay): ?string
    {
        $text = $plain;
        if ($liturgicalDay) {
            $text = str_replace($liturgicalDay, ' ', $text);
        }
        $text = preg_replace('/\bReadings for Today\b/i', ' ', $text) ?? $text;
        $text = preg_replace('/\bVideo\b/i', ' ', $text) ?? $text;
        $text = trim(preg_replace('/\s+/', ' ', $text) ?? $text);
        if ($text === '') {
            return null;
        }

        return Str::limit($text, 220);
    }

    protected function extractImage(string $html): ?string
    {
        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $m)) {
            $src = trim($m[1]);
            if ($src !== '' && str_starts_with($src, 'http')) {
                return $src;
            }
        }

        return null;
    }

    protected function sanitizeContentHtml(string $html): string
    {
        $html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html) ?? $html;
        $html = preg_replace('#<iframe\b[^>]*>.*?</iframe>#is', '', $html) ?? $html;
        $html = preg_replace('#<audio\b[^>]*>.*?</audio>#is', '', $html) ?? $html;
        $html = preg_replace('/\sstyle=("|\')(.*?)\1/i', '', $html) ?? $html;
        $html = preg_replace('/\son\w+=("|\')(.*?)\1/i', '', $html) ?? $html;

        $markers = [
            'More Gospel Reflections',
            'Divine Mercy Reflections',
            'All Saints/Feasts',
            'Scripture Meditations for Ordinary Time',
            'Mass Reading Options',
        ];
        foreach ($markers as $marker) {
            $pos = mb_stripos($html, $marker);
            if ($pos !== false) {
                $cut = mb_strripos(mb_substr($html, 0, $pos), '<p');
                if ($cut !== false && $cut > 200) {
                    $html = mb_substr($html, 0, $cut);
                    break;
                }
            }
        }

        $html = preg_replace('#^\s*<img[^>]*>\s*#is', '', $html, 1) ?? $html;

        return trim($html);
    }

    protected function plainText(string $html): string
    {
        $text = strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>', '</div>', '</li>'], "\n", $html));
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/[ \t]+/', ' ', preg_replace('/\n{3,}/', "\n\n", $text) ?? $text) ?? $text);
    }

    protected function map(): array
    {
        $map = Cache::get('daily_reflection.map', []);

        return is_array($map) ? $map : [];
    }

    protected function mappedReflection(string $date): ?array
    {
        $map = $this->map();
        $item = $map[$date] ?? null;

        return is_array($item) ? $item : null;
    }

    protected function rememberMapping(string $date, array $item): void
    {
        if (! $this->normalizeDate($date) || empty($item['title']) || empty($item['content_html'])) {
            return;
        }

        $map = $this->map();
        $map[$date] = array_merge($item, [
            'date' => $date,
            'date_label' => Carbon::createFromFormat('Y-m-d', $date, self::TIMEZONE)->format('l, j F Y'),
        ]);

        if (count($map) > 120) {
            ksort($map);
            $map = array_slice($map, -100, null, true);
        }

        Cache::put('daily_reflection.map', $map, now()->addYear());
    }
}