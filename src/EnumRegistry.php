<?php

declare(strict_types=1);

namespace Codeup\Enum;

/**
 * @deprecated in favor of \Codeup\Enum\BaseEnum::with()
 */
interface EnumRegistry
{
    /**
     * @param string $enumClassName
     * @param string $enumValue
     * @return \Codeup\Enum\Enum
     */
    public function getEnum(string $enumClassName, string $enumValue);
}
