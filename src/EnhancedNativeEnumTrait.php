<?php

declare(strict_types=1);

namespace Codeup\Enum;

use BackedEnum;

trait EnhancedNativeEnumTrait
{
    /**
     * @return string[]
     */
    public static function values(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[] = $case->value;
        }
        return $result;
    }

    /**
     * @param string|BackedEnum|Enum $value
     * @return bool
     */
    public function equals(string|BackedEnum|Enum $value): bool
    {
        if (is_string($value)) {
            return $value === $this->value;
        } elseif ($value instanceof Enum) {
            return $value->asEnum() === $this;
        } else {
            return $value === $this;
        }
    }
}
