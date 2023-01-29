<?php

declare(strict_types=1);

namespace Codeup\Enum;

use BackedEnum;
use UnitEnum;

interface EnhancedNativeEnum extends UnitEnum
{
    /**
     * @return string[]
     */
    public static function values(): array;

    /**
     * @param string|BackedEnum|UnitEnum|Enum $value
     * @return bool
     */
    public function equals(string|BackedEnum|UnitEnum|Enum $value): bool;
}
