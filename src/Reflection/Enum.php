<?php

namespace Codeup\Enum\Reflection;

use DomainException;
use ReflectionClass;

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
        if (in_array($value, $this->getValidValues(), true)) {
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
    private function getValidValues(): array
    {
        $class = get_class($this);
        if (!isset(self::$reflectedEnumValues[$class])) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $reflection = new ReflectionClass($class);
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
    public final function __toString(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return bool
     */
    public final function is(string $value): bool
    {
        return $value === $this->value;
    }

    /**
     * @param \Codeup\Enum\Enum $enum
     * @return bool
     */
    public final function equals(\Codeup\Enum\Enum $enum): bool
    {
        return $enum === $this
            || get_class($enum) === get_class($this) && (string)$enum === (string)$this;
    }
}
