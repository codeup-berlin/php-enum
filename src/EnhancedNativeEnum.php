<?php

declare(strict_types=1);

namespace Codeup\Enum;

use BackedEnum;
use JsonSerializable;
use UnitEnum;

interface EnhancedNativeEnum extends UnitEnum, JsonSerializable
{
    /**
     * @return string[]
     */
    public static function values(): array;

    /**
     * @return string
     */
    public function value(): string;

    /**
     * @param string $value
     * @return static
     */
    public static function fromValue(string $value): static;

    /**
     * @param string $value
     * @return static|null
     */
    public static function tryFromValue(string $value): ?static;

    /**
     * @param string|BackedEnum|UnitEnum|Enum $value
     * @return bool
     */
    public function equals(string|BackedEnum|UnitEnum|Enum $value): bool;
}
