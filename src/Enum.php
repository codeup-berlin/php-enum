<?php

declare(strict_types=1);

namespace Codeup\Enum;

use BackedEnum;
use JsonSerializable;
use UnitEnum;

interface Enum extends JsonSerializable
{
    /**
     * @return array<BackedEnum|UnitEnum>
     */
    public static function cases(): array;

    /**
     * @param string|BackedEnum|UnitEnum $value
     * @return static
     */
    public static function from(string|BackedEnum|UnitEnum $value): static;

    /**
     * @param string|BackedEnum|UnitEnum $value
     * @return static|null
     */
    public static function tryFrom(string|BackedEnum|UnitEnum $value): ?static;

    /**
     * @return string
     */
    public function asString(): string;

    /**
     * @return BackedEnum|UnitEnum
     */
    public function asEnum(): BackedEnum|UnitEnum;
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
