<?php

namespace Codeup\Enum;

interface Enum
{
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
