<?php

namespace Codeup\Enum\Standard;

use Codeup\Enum\Enum;
use InvalidArgumentException;

class Registry implements \Codeup\Enum\Registry
{
    /**
     * @var \Codeup\Enum\Enum[][]
     */
    private $instances = [];

    /**
     * @param string $enumClassName
     * @param string $enumValue
     * @return \Codeup\Enum\Enum
     */
    public function getEnum(string $enumClassName, string $enumValue)
    {
        if (!class_exists($enumClassName)) {
            throw new InvalidArgumentException('Class not found: ' . $enumClassName);
        }
        if (!is_subclass_of($enumClassName, Enum::class)) {
            throw new InvalidArgumentException(sprintf(
                'Class not subclass of %s: %s',
                Enum::class, $enumClassName
            ));
        }
        if (!isset($this->instances[$enumClassName][$enumValue])) {
            $this->instances[$enumClassName][$enumValue] = new $enumClassName($enumValue);
        }
        return $this->instances[$enumClassName][$enumValue];
    }
}
