<?php

declare(strict_types=1);

namespace Codeup\Enum;

use BackedEnum;

interface EnhancedNativeEnum extends BackedEnum
{
    /**
     * @return string[]
     */
    public static function values(): array;

    /**
     * @param string|BackedEnum|Enum $value
     * @return bool
     */
    public function equals(string|BackedEnum|Enum $value): bool;
}
