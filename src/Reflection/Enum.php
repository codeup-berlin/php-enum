<?php

declare(strict_types=1);

namespace Codeup\Enum\Reflection;

use BackedEnum;
use ReflectionClass;
use UnexpectedValueException;
use UnitEnum;
use ValueError;

abstract class Enum implements \Codeup\Enum\Enum
{
    /**
     * @var string
     */
    public readonly string $name;

    /**
     * @var BackedEnum
     */
    public readonly BackedEnum $case;

    /**
     * @var array<string,BackedEnum>|null
     */
    private static ?array $reflectedCases = null;

    /**
     * @var string[]|null
     */
    private static ?array $reflectedValues = null;

    /**
     * @var static[]|null
     */
    private static ?array $instances = [];

    /**
     * @param string $value
     */
    private function __construct(
        public readonly string $value
    ) {
        self::initReflection();
        $caseFound = false;
        foreach (self::$reflectedCases[get_called_class()] as $name => $case) {
            if ($value === $case->value) {
                $this->name = $name;
                $this->case = $case;
                $caseFound = true;
                break;
            }
        }
        if (!$caseFound) {
            throw new ValueError("Enum value unknown: \"$value\"");
        }
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        return $this->value;
    }

    /**
     * @return BackedEnum
     */
    public function asEnum(): BackedEnum
    {
        return $this->case;
    }

    /**
     * @param string|BackedEnum|UnitEnum $value
     * @return static
     * @throws ValueError
     */
    public static function from(string|BackedEnum|UnitEnum $value): static
    {
        $value = ($value instanceof BackedEnum) ? $value->value : (
            ($value instanceof UnitEnum) ? $value->name : $value
        );
        $class = get_called_class();
        if (!isset(self::$instances[$class][$value])) {
            self::$instances[$class][$value] = new static($value);
        }
        return self::$instances[$class][$value];
    }

    /**
     * @param string|BackedEnum|UnitEnum $value
     * @return static|null
     */
    public static function tryFrom(string|BackedEnum|UnitEnum $value): ?static
    {
        try {
            return self::from($value);
        } catch (ValueError) {
            return null;
        }
    }

    private static function initReflection(): void
    {
        $class = get_called_class();
        if (!isset(self::$reflectedCases[$class])) {
            $reflection = new ReflectionClass(get_called_class());
            $reflectedCases = [];
            $reflectedValues = [];
            $values = [];
            foreach ($reflection->getConstants() as $name => $case) {
                if (!($case instanceof UnitEnum)) {
                    throw new UnexpectedValueException("Constant \"$class::$name\" is not an enum.");
                }
                $value = ($case instanceof BackedEnum) ? $case->value : $case->name;
                if (isset($values[$value])) {
                    throw new UnexpectedValueException("Ambiguous enum value: $value");
                }
                $values[$value] = true;
                $reflectedCases[$name] = $case;
                $reflectedValues[] = $value;
            }
            self::$reflectedCases[$class] = $reflectedCases;
            self::$reflectedValues[$class] = $reflectedValues;
        }
    }

    /**
     * @return array<BackedEnum|UnitEnum>
     */
    public static function cases(): array
    {
        self::initReflection();
        return array_values(self::$reflectedCases[get_called_class()]);
    }

    /**
     * @return string[]
     */
    public static function values(): array
    {
        self::initReflection();
        return self::$reflectedValues[get_called_class()];
    }

    /**
     * @param string|BackedEnum|UnitEnum|\Codeup\Enum\Enum $value
     * @return bool
     */
    public function equals(string|BackedEnum|UnitEnum|\Codeup\Enum\Enum $value): bool
    {
        if (is_string($value)) {
            return $value === $this->value;
        } elseif ($value instanceof UnitEnum) {
            return $value === $this->case;
        } else {
            return $value === $this;
        }
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
