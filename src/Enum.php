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
     * @param string $value
     * @return static
     */
    public static function fromValue(string $value): static;

    /**
     * @param string|BackedEnum|UnitEnum $value
     * @return static|null
     */
    public static function tryFrom(string|BackedEnum|UnitEnum $value): ?static;

    /**
     * @param string $value
     * @return static|null
     */
    public static function tryFromValue(string $value): ?static;

    /**
     * @return string
     * @deprecated in favor of value()
     */
    public function asString(): string;

    /**
     * @return string
     */
    public function value(): string;

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
