<?php

declare(strict_types=1);

namespace Codeup\Enum;

use BackedEnum;
use JsonSerializable;

interface Enum extends JsonSerializable
{
    /**
     * @return BackedEnum[]
     */
    public static function cases(): array;

    /**
     * @param string|BackedEnum $value
     * @return static
     */
    public static function from(string|BackedEnum $value): static;

    /**
     * @param string|BackedEnum $value
     * @return static|null
     */
    public static function tryFrom(string|BackedEnum $value): ?static;

    /**
     * @return string
     */
    public function asString(): string;

    /**
     * @return BackedEnum
     */
    public function asEnum(): BackedEnum;
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
