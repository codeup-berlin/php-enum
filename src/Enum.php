<?php

declare(strict_types=1);

namespace Codeup\Enum;

use JsonSerializable;

interface Enum extends JsonSerializable
{
    /**
     * @param string $value
     * @return $this
     * @deprecated in favor of from(), will be removed with PHP 8.1 native enum support
     */
    public static function with(string $value): Enum;

    /**
     * @param string $value
     * @return $this
     */
    public static function from(string $value): Enum;

    /**
     * @return string[]
     * @deprecated in favor of values(), will be removed with PHP 8.1 native enum support
     */
    public static function getEnumValues(): array;

    /**
     * @return string[]
     */
    public static function values(): array;

    /**
     * @return string
     * @deprecated in favor of asString(), will be removed with PHP 8.1 native enum support
     */
    public function __toString(): string;

    /**
     * @return string
     */
    public function asString(): string;

    /**
     * @param string $value
     * @return bool
     */
    public function is(string $value): bool;

    /**
     * @param \Codeup\Enum\Enum $enum
     * @return bool
     */
    public function equals(Enum $enum): bool;

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): string;
}
