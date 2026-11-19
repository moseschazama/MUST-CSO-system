<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * A tiny, dependency-free PDF writer for text documents.
 *
 * It intentionally supports only the small feature set the CSO needs:
 * headings, wrapped paragraphs, bullet lists and a footer. That keeps PDF
 * downloads working without adding a Composer package to the project.
 */
class SimplePdf
{
    private const PAGE_WIDTH = 595.28;

    private const PAGE_HEIGHT = 841.89;

    private const MARGIN = 56.0;

    private const CONTENT_WIDTH = 483.28;

    private const BOTTOM = 64.0;

    private const NAVY = [0.06, 0.09, 0.16];

    private const INK = [0.25, 0.29, 0.35];

    private const MUTED = [0.43, 0.48, 0.56];

    private const GOLD = [0.78, 0.61, 0.15];

    /** @var array<int, array<int, string>> */
    private array $pages = [[]];

    private int $current = 0;

    private float $y = 0.0;

    private string $footer;

    public function __construct(private readonly string $documentTitle)
    {
        $this->footer = 'MUST CSO - Generated '.now()->format('j M Y');
        $this->y = self::PAGE_HEIGHT - 82;
    }

    public static function make(string $title, ?string $subtitle = null): self
    {
        $pdf = new self($title);
        $pdf->drawHeader($title, $subtitle);

        return $pdf;
    }

    public function meta(string $text): self
    {
        $this->paragraph($text, 9, false, self::MUTED, 12);

        return $this;
    }

    public function heading(string $text): self
    {
        $this->spaceBefore(12);
        $this->paragraph($text, 13, true, self::NAVY, 18);

        return $this;
    }

    public function subheading(string $text): self
    {
        $this->spaceBefore(6);
        $this->paragraph($text, 11, true, self::NAVY, 15);

        return $this;
    }

    public function text(string $text): self
    {
        $this->paragraph($text, 10.5, false, self::INK, 15);

        return $this;
    }

    public function bullet(string $text): self
    {
        $lines = $this->wrap($text, 10.5, self::CONTENT_WIDTH - 16);

        foreach ($lines as $index => $line) {
            $this->ensureSpace(15);
            $prefix = $index === 0 ? '- ' : '  ';
            $this->write($this->textCommand($prefix.$line, 10.5, false, self::INK, self::MARGIN + 8, $this->y));
            $this->y -= 15;
        }

        return $this;
    }

    public function note(string $text): self
    {
        $this->spaceBefore(8);
        $this->paragraph($text, 9, false, self::MUTED, 13);

        return $this;
    }

    public function divider(): self
    {
        $this->ensureSpace(14);
        $this->write(sprintf('0.86 0.88 0.91 RG 0.7 w %.2F %.2F m %.2F %.2F l S', self::MARGIN, $this->y, self::MARGIN + self::CONTENT_WIDTH, $this->y));
        $this->y -= 14;

        return $this;
    }

    public function space(float $points = 8): self
    {
        $this->y -= $points;

        return $this;
    }

    public function output(): string
    {
        $this->addFooters();

        $objects = [];
        $pageIds = [];
        $nextId = 5;

        foreach ($this->pages as $commands) {
            $pageId = $nextId++;
            $contentId = $nextId++;
            $stream = implode("\n", $commands);

            $objects[$pageId] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 '.self::PAGE_WIDTH.' '.self::PAGE_HEIGHT.'] /Resources << /Font << /F1 3 0 R /F2 4 0 R >> /ProcSet [/PDF /Text] >> /Contents '.$contentId.' 0 R >>';
            $objects[$contentId] = '<< /Length '.strlen($stream)." >>\nstream\n".$stream."\nendstream";
            $pageIds[] = $pageId.' 0 R';
        }

        $objects[1] = '<< /Type /Catalog /Pages 2 0 R >>';
        $objects[2] = '<< /Type /Pages /Kids ['.implode(' ', $pageIds).'] /Count '.count($this->pages).' >>';
        $objects[3] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>';
        $objects[4] = '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >>';

        ksort($objects);

        $pdf = "%PDF-1.4\n%\xE2\xE3\xCF\xD3\n";
        $offsets = [];

        foreach ($objects as $id => $body) {
            $offsets[$id] = strlen($pdf);
            $pdf .= $id." 0 obj\n".$body."\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $count = count($objects) + 1;
        $pdf .= 'xref'."\n".'0 '.$count."\n";
        $pdf .= "0000000000 65535 f \n";

        for ($id = 1; $id < $count; $id++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$id]);
        }

        $pdf .= 'trailer'."\n".'<< /Size '.$count.' /Root 1 0 R >>'."\n";
        $pdf .= 'startxref'."\n".$xrefOffset."\n%%EOF";

        return $pdf;
    }

    private function drawHeader(string $title, ?string $subtitle): void
    {
        $this->write(sprintf('0.06 0.09 0.16 rg 0 %.2F %.2F 18 re f', self::PAGE_HEIGHT - 18, self::PAGE_WIDTH));
        $this->write(sprintf('0.78 0.61 0.15 rg 0 %.2F %.2F 3 re f', self::PAGE_HEIGHT - 21, self::PAGE_WIDTH));

        $this->paragraph($title, 22, true, self::NAVY, 28);

        if (filled($subtitle)) {
            $this->paragraph($subtitle, 10, false, self::MUTED, 14);
        }

        $this->divider();
    }

    private function paragraph(string $text, float $size, bool $bold, array $color, float $lineHeight): void
    {
        foreach ($this->wrap($text, $size) as $line) {
            $this->ensureSpace($lineHeight);
            $this->write($this->textCommand($line, $size, $bold, $color, self::MARGIN, $this->y));
            $this->y -= $lineHeight;
        }
    }

    private function spaceBefore(float $points): void
    {
        if ($this->y < self::PAGE_HEIGHT - 100) {
            $this->y -= $points;
        }
    }

    private function ensureSpace(float $height): void
    {
        if ($this->y - $height < self::BOTTOM) {
            $this->current++;
            $this->pages[$this->current] = [];
            $this->y = self::PAGE_HEIGHT - self::MARGIN;
        }
    }

    private function write(string $command): void
    {
        $this->pages[$this->current][] = $command;
    }

    private function textCommand(string $text, float $size, bool $bold, array $color, float $x, float $y): string
    {
        return sprintf(
            'BT /F%d %.2F Tf %.3F %.3F %.3F rg %.2F %.2F Td (%s) Tj ET',
            $bold ? 2 : 1,
            $size,
            $color[0],
            $color[1],
            $color[2],
            $x,
            $y,
            $this->escape($text),
        );
    }

    /** @return array<int, string> */
    private function wrap(string $text, float $size, ?float $width = null): array
    {
        $text = trim((string) preg_replace('/\s+/u', ' ', $text));

        if ($text === '') {
            return [''];
        }

        $maxChars = max(18, (int) floor(($width ?? self::CONTENT_WIDTH) / ($size * 0.50)));

        return explode("\n", wordwrap($text, $maxChars, "\n", true));
    }

    private function escape(string $text): string
    {
        $text = Str::ascii($text);
        $text = str_replace(["\r", "\n"], ' ', $text);

        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }

    private function addFooters(): void
    {
        $total = count($this->pages);

        foreach ($this->pages as $index => $commands) {
            $pageNumber = $index + 1;
            $commands[] = sprintf('0.86 0.88 0.91 RG 0.5 w %.2F 48 m %.2F 48 l S', self::MARGIN, self::MARGIN + self::CONTENT_WIDTH);
            $commands[] = $this->textCommand($this->footer, 8, false, self::MUTED, self::MARGIN, 34);
            $commands[] = $this->textCommand('Page '.$pageNumber.' of '.$total, 8, false, self::MUTED, self::MARGIN + self::CONTENT_WIDTH - 54, 34);

            $this->pages[$index] = $commands;
        }
    }
}
