<?php

namespace Codeup\Enum;

use DomainException;

abstract class BaseEnum implements Enum
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
