<?php

declare(strict_types=1);

namespace Codeup\Enum;

use BackedEnum;
use UnitEnum;

trait EnhancedNativeEnumTrait
{
    /**
     * @return string[]
     */
    public static function values(): array
    {
        $isBacked = is_a(get_called_class(), BackedEnum::class, true);
        $result = [];
        foreach (self::cases() as $case) {
            $result[] = $isBacked ? $case->value : $case->name;
        }
        return $result;
    }

    /**
     * @param string|BackedEnum|UnitEnum|Enum $value
     * @return bool
     */
    public function equals(string|BackedEnum|UnitEnum|Enum $value): bool
    {
        if (is_string($value)) {
            $isBacked = $this instanceof BackedEnum;
            return $value === ($isBacked ? $this->value : $this->name);
        } elseif ($value instanceof Enum) {
            return $value->asEnum() === $this;
        } else {
            return $value === $this;
        }
    }
}