<?php

namespace Codeup\Enum\Standard;

use Codeup\Enum\Enum;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TestEnum implements Enum
{
    const SOME_VALUE = 'some value';

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return '';
    }

    /**
     * @param string $value
     * @return bool
     */
    public function is(string $value): bool
    {
        return false;
    }

    /**
     * @param \Codeup\Enum\Enum $enum
     * @return bool
     */
    public function equals(Enum $enum): bool
    {
        return false;
    }
}

class RegistryTest extends TestCase
{
    /**
     * @var Registry
     */
    private $classUnderTest;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->classUnderTest = new Registry();
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
    }
}
