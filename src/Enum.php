<?php

namespace Codeup\Enum;

interface Enum
{
    /**
     * @param string $value
     */
    public function __construct(string $value);

    /**
     * @return string[]
     */
    public static function getEnumValues(): array;

    /**
     * @return string
     */
    public function __toString(): string;

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
}
