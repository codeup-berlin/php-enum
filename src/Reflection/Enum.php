<?php

namespace Codeup\Enum\Reflection;

use DomainException;
use LogicException;
use ReflectionClass;
use ReflectionException;

class Enum implements \Codeup\Enum\Enum
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (in_array($value, static::getEnumValues(), true)) {
            $this->value = $value;
        } else {
            throw new DomainException(sprintf(
                'Value not known for Enum \\%s: %s', get_class($this), $value
            ));
        }
    }

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

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function is(string $value): bool
    {
        return $value === $this->value;
    }

    /**
     * @param \Codeup\Enum\Enum $enum
     * @return bool
     */
    public function equals(\Codeup\Enum\Enum $enum): bool
    {
        return $enum === $this
            || get_class($enum) === get_class($this) && (string)$enum === (string)$this;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
