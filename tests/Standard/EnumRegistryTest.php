<?php

namespace Codeup\Enum\Standard;

use Codeup\Enum\Enum;
use InvalidArgumentException;
use LogicException;
use PHPUnit\Framework\TestCase;

class TestEnum implements Enum
{
    const SOME_VALUE = 'some value';
    const SOME_OTHER_VALUE = 'some other value';

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

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
        return [
            self::SOME_VALUE,
            self::SOME_OTHER_VALUE,
        ];
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
        return $this->__toString() === $value;
    }

    /**
     * @param \Codeup\Enum\Enum $enum
     * @return bool
     */
    public function equals(Enum $enum): bool
    {
        return $this === $enum;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): string
    {
        return $this->value;
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
        throw new LogicException('Not implemented.');
    }
}

class RegistryTest extends TestCase
{
    /**
     * @var EnumRegistry
     */
    private $classUnderTest;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->classUnderTest = new EnumRegistry();
    }

    /**
     * @test
     */
    public function get_withUnknownClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->classUnderTest->getEnum('someUnknownClass', 'someArbitraryValue');
    }

    /**
     * @test
     */
    public function get_withNonEnumClass()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->classUnderTest->getEnum(self::class, 'someArbitraryValue');
    }

    /**
     * @test
     */
    public function get_withKnownEnumClass()
    {
        $result = $this->classUnderTest->getEnum(TestEnum::class, TestEnum::SOME_VALUE);
        $this->assertInstanceOf(TestEnum::class, $result);
    }

    /**
     * @test
     */
    public function get_multipleWithSameEnum()
    {
        $result = $this->classUnderTest->getEnum(TestEnum::class, TestEnum::SOME_VALUE);
        $result2 = $this->classUnderTest->getEnum(TestEnum::class, TestEnum::SOME_VALUE);
        $this->assertSame($result, $result2);
        $this->assertSame(TestEnum::SOME_VALUE, (string)$result);
        $this->assertSame(TestEnum::SOME_VALUE, (string)$result2);
    }

    /**
     * @test
     */
    public function get_multipleWithDifferentEnum()
    {
        $result = $this->classUnderTest->getEnum(TestEnum::class, TestEnum::SOME_VALUE);
        $result2 = $this->classUnderTest->getEnum(TestEnum::class, TestEnum::SOME_OTHER_VALUE);
        $this->assertNotSame($result, $result2);
        $this->assertSame(TestEnum::SOME_VALUE, (string)$result);
        $this->assertSame(TestEnum::SOME_OTHER_VALUE, (string)$result2);
    }
}
