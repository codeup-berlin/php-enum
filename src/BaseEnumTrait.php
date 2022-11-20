<?php

declare(strict_types=1);

namespace Codeup\Enum;

use DomainException;

/**
 * @internal
 * @deprecated in favor of interface Enum and trait StringBacked, will be removed with PHP 8.1 native enum support
 */
trait BaseEnumTrait
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var array<string, array<string, Enum>>
     */
    private static $registry = [];

    /**
     * @return void
     */
    protected static function clearRegistry(): void
    {
        self::$registry = [];
    }

    /**
     * @param string $value
     * @return $this
     * @deprecated in favor of from(), will be removed with PHP 8.1 native enum support
     */
    public static function with(string $value): Enum
    {
        return self::from($value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public static function from(string $value): Enum
    {
        $class = get_called_class();
        if (!isset(self::$registry[$class][$value])) {
            self::$registry[$class][$value] = new static($value);
        }
        return self::$registry[$class][$value];
    }

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
     * @return string
     * @deprecated in favor of asString(), will be removed with PHP 8.1 native enum support
     */
    public function __toString(): string
    {
        return $this->asString();
    }

    /**
     * @return string
     */
    public function asString(): string
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
    public function equals(Enum $enum): bool
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
