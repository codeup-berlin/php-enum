<?php

namespace Codeup\Enum;

interface Registry
{
    /**
     * @param string $enumClassName
     * @param string $enumValue
     * @return \Codeup\Enum\Enum
     */
    public function getEnum(string $enumClassName, string $enumValue);
}
