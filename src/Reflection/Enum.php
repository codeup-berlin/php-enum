<?php

namespace Codeup\Enum\Reflection;

use Codeup\Enum\BaseEnum;
use LogicException;
use ReflectionClass;
use ReflectionException;

class Enum extends BaseEnum implements \Codeup\Enum\Enum
{
    /**
     * @var array
     */
    private static $reflectedEnumValues = [];

    /**
     * @return string[]
     */
    public static function getEnumValues(): array
    {
        $class = get_called_class();
        if (!isset(self::$reflectedEnumValues[$class])) {
            try {
                $reflection = new ReflectionClass($class);
            } catch (ReflectionException $e) {
                throw new LogicException($e->getMessage(), $e->getCode(), $e);
            }
            self::$reflectedEnumValues[$class] = [];
            foreach (array_values($reflection->getConstants()) as $value) {
                self::$reflectedEnumValues[$class][] = (string)$value;
            };
            self::$reflectedEnumValues[$class] = array_unique(self::$reflectedEnumValues[$class]);
        }
        return self::$reflectedEnumValues[$class];
    }
}
