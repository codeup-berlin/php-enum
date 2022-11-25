<?php

declare(strict_types=1);

namespace Codeup\Enum\Reflection;

use LogicException;
use ReflectionClass;
use ReflectionException;

/**
 * @internal
 * @deprecated in favor of interface Enum and trait StringBackedEnum, will be removed with PHP 8.1 native enum support
 */
trait EnumTrait
{
    /**
     * @var array
     */
    private static $reflectedEnumValues = [];

    /**
     * @return string[]
     * @deprecated in favor of values(), will be removed with PHP 8.1 native enum support
     */
    public static function getEnumValues(): array
    {
        return self::values();
    }

    /**
     * @return string[]
     */
    public static function values(): array
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
