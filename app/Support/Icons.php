<?php

namespace App\Support;

class Icons
{
    /**
     * Cached Lucide + brand icon paths (inner SVG markup).
     */
    private static ?array $icons = null;

    public static function get(string $name): string
    {
        if (self::$icons === null) {
            self::$icons = array_merge(
                require resource_path('icons-brand.php'),
                require resource_path('icons.php'),
            );
        }

        return self::$icons[$name] ?? self::$icons['star'];
    }
}
