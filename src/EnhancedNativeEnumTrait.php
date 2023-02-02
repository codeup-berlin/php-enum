<?php

declare(strict_types=1);

namespace Codeup\Enum;

use BackedEnum;
use Throwable;
use UnitEnum;
use ValueError;

trait EnhancedNativeEnumTrait
{
    /**
     * @return string[]
     */
    public static function values(): array
    {
        $isBacked = self::isBacked();
        $result = [];
        foreach (self::cases() as $case) {
            $result[] = $isBacked ? $case->value : $case->name;
        }
        return $result;
    }

    /**
     * @return bool
     */
    private static function isBacked(): bool
    {
        return is_a(get_called_class(), BackedEnum::class, true);
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return ($this instanceof BackedEnum) ? $this->value : $this->name;
    }

    /**
     * @param string $value
     * @return static
     */
    private static function pureFrom(string $value): static
    {
        try {
            return constant("self::$value");
        } catch (Throwable) {
            $class = get_called_class();
            throw new ValueError("\"$value\" is not a valid backing value for enum \"$class\"");
        }
    }

    /**
     * @param string $value
     * @return static
     */
    public static function fromValue(string $value): static
    {
        return self::isBacked() ? self::from($value) : self::pureFrom($value);
    }

    /**
     * @param string $value
     * @return static|null
     */
    private static function pureTryFrom(string $value): mixed
    {
        try {
            return self::pureFrom($value);
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @param string $value
     * @return static|null
     */
    public static function tryFromValue(string $value): ?static
    {
        return self::isBacked() ? self::tryFrom($value) : self::pureTryFrom($value);
    }

    /**
     * @param string|BackedEnum|UnitEnum|Enum $value
     * @return bool
     */
    public function equals(string|BackedEnum|UnitEnum|Enum $value): bool
    {
        if (is_string($value)) {
            return $this->value() === $value;
        } elseif ($value instanceof Enum) {
            return $value->asEnum() === $this;
        } else {
            return $value === $this;
        }
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): string
    {
        return $this->value();
    }
}
