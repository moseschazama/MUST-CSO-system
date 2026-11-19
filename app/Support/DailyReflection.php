<?php

namespace App\Support;

class DailyReflection
{
    /**
     * A small rotating set of scripture and reflections so the home page
     * always has a current word without requiring an external feed.
     */
    public const ENTRIES = [
        [
            'verse' => 'Come to me, all you who are weary and burdened, and I will give you rest.',
            'reference' => 'Matthew 11:28',
            'reflection' => 'Campus life can move quickly. Today, bring one worry to Christ before you open your books. Rest is not laziness; it is trust in the One who holds your future.',
        ],
        [
            'verse' => 'The Lord is my shepherd; I shall not want.',
            'reference' => 'Psalm 23:1',
            'reflection' => 'The Shepherd knows the path even when the timetable is unclear. Let this psalm shape your pace today: you are known, guided and provided for.',
        ],
        [
            'verse' => 'Trust in the Lord with all your heart and lean not on your own understanding.',
            'reference' => 'Proverbs 3:5',
            'reflection' => 'Not every question has an answer today. Trust grows in the space between what we know and what we place in God’s hands.',
        ],
        [
            'verse' => 'I am the light of the world. Whoever follows me will never walk in darkness.',
            'reference' => 'John 8:12',
            'reflection' => 'A Catholic student is called to carry light into lecture halls, hostels and friendships. Ask Christ to make your words and choices clear and warm today.',
        ],
        [
            'verse' => 'Do not be afraid, for I am with you; do not be dismayed, for I am your God.',
            'reference' => 'Isaiah 41:10',
            'reflection' => 'Fear often speaks loudly before faith has a chance to answer. Stand still for a moment, breathe, and remember who is with you.',
        ],
        [
            'verse' => 'Let all that you do be done in love.',
            'reference' => '1 Corinthians 16:14',
            'reflection' => 'Love is the measure of a day’s work. A kind greeting, a patient reply or a hidden act of service can turn an ordinary Tuesday into prayer.',
        ],
        [
            'verse' => 'Ask, and it will be given to you; seek, and you will find; knock, and it will be opened to you.',
            'reference' => 'Matthew 7:7',
            'reflection' => 'Prayer is not a last resort; it is the first conversation of the day. Bring your studies, relationships and hopes to God with confidence.',
        ],
    ];

    public static function today(): array
    {
        $index = now()->dayOfYear % count(self::ENTRIES);

        return self::ENTRIES[$index];
    }
}
