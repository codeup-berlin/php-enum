<?php

namespace Codeup\Enum;

use DomainException;
use PHPUnit\Framework\TestCase;

class TestEnum extends BaseEnum {
    const SOME_VALUE = 'some value';
    const ANOTHER_VALUE = 'another value';
    /**
     * @return string[]
     */
    public static function getEnumValues(): array
    {
        return [
            self::SOME_VALUE,
            self::ANOTHER_VALUE,
        ];
    }
    /**
     * @return void
     */
    public static function reset(): void
    {
        self::clearRegistry();
    }
}

class TestEnum2 extends BaseEnum {
    const SOME_VALUE = 'some value';
    const A_VERY_OTHER_VALUE = 'a very other value';
    /**
     * @return string[]
     */
    public static function getEnumValues(): array
    {
        return [
            self::SOME_VALUE,
            self::A_VERY_OTHER_VALUE,
        ];
    }
    /**
     * @return void
     */
    public static function reset(): void
    {
        self::clearRegistry();
    }
}

class BaseEnumTest extends TestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        TestEnum::reset();
        TestEnum2::reset();
    }

    /**
     * Explicit instance assertions method is useful to test IDE type hint abilities at calling side.
     * @param \Codeup\Enum\TestEnum $enum
     */
    private function assertTestEnumType(TestEnum $enum): void
    {
        $this->assertInstanceOf(TestEnum::class, $enum);
    }

    /**
     * @test
     */
    public function with_validValue()
    {
        $enum = TestEnum::with(TestEnum::SOME_VALUE);
        $this->assertTestEnumType($enum);
        $this->assertSame(TestEnum::SOME_VALUE, (string)$enum);
    }

    /**
     * @test
     */
    public function with_invalidValue()
    {
        $this->expectException(DomainException::class);
        TestEnum::with('What?');
    }

    /**
     * @test
     */
    public function with_sameEnum_sameValue()
    {
        $enum1 = TestEnum::with(TestEnum::SOME_VALUE);
        $enum2 = TestEnum::with(TestEnum::SOME_VALUE);
        $this->assertSame(TestEnum::SOME_VALUE, (string)$enum1);
        $this->assertSame(TestEnum::SOME_VALUE, (string)$enum2);
        $this->assertSame($enum1, $enum2);
    }

    /**
     * @test
     */
    public function with_sameEnum_differentValue()
    {
        $enum1 = TestEnum::with(TestEnum::SOME_VALUE);
        $enum2 = TestEnum::with(TestEnum::ANOTHER_VALUE);
        $this->assertSame(TestEnum::SOME_VALUE, (string)$enum1);
        $this->assertSame(TestEnum::ANOTHER_VALUE, (string)$enum2);
        $this->assertNotSame($enum1, $enum2);
    }

    /**
     * @test
     */
    public function with_differentEnum_differentValue()
    {
        $enum1 = TestEnum::with(TestEnum::SOME_VALUE);
        $enum2 = TestEnum2::with(TestEnum2::A_VERY_OTHER_VALUE);
        $this->assertSame(TestEnum::SOME_VALUE, (string)$enum1);
        $this->assertSame(TestEnum2::A_VERY_OTHER_VALUE, (string)$enum2);
        $this->assertNotSame($enum1, $enum2);
    }

    /**
     * @test
     */
    public function with_differentEnum_sameValue()
    {
        $enum1 = TestEnum::with(TestEnum::SOME_VALUE);
        $enum2 = TestEnum2::with(TestEnum2::SOME_VALUE);
        $this->assertSame(TestEnum::SOME_VALUE, (string)$enum1);
        $this->assertSame(TestEnum2::SOME_VALUE, (string)$enum2);
        $this->assertNotSame($enum1, $enum2);
    }
}
