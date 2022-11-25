<?php

namespace Codeup\Enum;

use DomainException;
use PHPUnit\Framework\TestCase;

class StringBackedTestEnum implements Enum {
    use StringBackedEnum;

    const SOME_VALUE = 'some value';
    const ANOTHER_VALUE = 'another value';
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

class StringBackedTestEnum2 implements Enum {
    use StringBackedEnum;

    const SOME_VALUE = 'some value';
    const A_VERY_OTHER_VALUE = 'a very other value';
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

class StringBackedEnumTest extends TestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        StringBackedTestEnum::reset();
        StringBackedTestEnum2::reset();
    }

    /**
     * Explicit instance assertions method is useful to test IDE type hint abilities at calling side.
     * @param \Codeup\Enum\StringBackedTestEnum $enum
     */
    private function assertTestEnumType(StringBackedTestEnum $enum): void
    {
        $this->assertInstanceOf(StringBackedTestEnum::class, $enum);
    }

    /**
     * @test
     */
    public function with_validValue()
    {
        $enum = StringBackedTestEnum::with(StringBackedTestEnum::SOME_VALUE);
        $this->assertTestEnumType($enum);
        $this->assertSame(StringBackedTestEnum::SOME_VALUE, (string)$enum);
    }

    /**
     * @test
     */
    public function from_validValue()
    {
        $enum = StringBackedTestEnum::from(StringBackedTestEnum::SOME_VALUE);
        $this->assertTestEnumType($enum);
        $this->assertSame(StringBackedTestEnum::SOME_VALUE, (string)$enum);
    }

    /**
     * @test
     */
    public function with_invalidValue()
    {
        $this->expectException(DomainException::class);
        StringBackedTestEnum::with('What?');
    }

    /**
     * @test
     */
    public function from_invalidValue()
    {
        $this->expectException(DomainException::class);
        StringBackedTestEnum::from('What?');
    }

    /**
     * @test
     */
    public function with_sameEnum_sameValue()
    {
        $enum1 = StringBackedTestEnum::with(StringBackedTestEnum::SOME_VALUE);
        $enum2 = StringBackedTestEnum::with(StringBackedTestEnum::SOME_VALUE);
        $this->assertSame(StringBackedTestEnum::SOME_VALUE, (string)$enum1);
        $this->assertSame(StringBackedTestEnum::SOME_VALUE, (string)$enum2);
        $this->assertSame($enum1, $enum2);
    }

    /**
     * @test
     */
    public function from_sameEnum_sameValue()
    {
        $enum1 = StringBackedTestEnum::from(StringBackedTestEnum::SOME_VALUE);
        $enum2 = StringBackedTestEnum::from(StringBackedTestEnum::SOME_VALUE);
        $this->assertSame(StringBackedTestEnum::SOME_VALUE, (string)$enum1);
        $this->assertSame(StringBackedTestEnum::SOME_VALUE, (string)$enum2);
        $this->assertSame($enum1, $enum2);
    }

    /**
     * @test
     */
    public function with_sameEnum_differentValue()
    {
        $enum1 = StringBackedTestEnum::with(StringBackedTestEnum::SOME_VALUE);
        $enum2 = StringBackedTestEnum::with(StringBackedTestEnum::ANOTHER_VALUE);
        $this->assertSame(StringBackedTestEnum::SOME_VALUE, (string)$enum1);
        $this->assertSame(StringBackedTestEnum::ANOTHER_VALUE, (string)$enum2);
        $this->assertNotSame($enum1, $enum2);
    }

    /**
     * @test
     */
    public function from_sameEnum_differentValue()
    {
        $enum1 = StringBackedTestEnum::from(StringBackedTestEnum::SOME_VALUE);
        $enum2 = StringBackedTestEnum::from(StringBackedTestEnum::ANOTHER_VALUE);
        $this->assertSame(StringBackedTestEnum::SOME_VALUE, (string)$enum1);
        $this->assertSame(StringBackedTestEnum::ANOTHER_VALUE, (string)$enum2);
        $this->assertNotSame($enum1, $enum2);
    }

    /**
     * @test
     */
    public function with_differentEnum_differentValue()
    {
        $enum1 = StringBackedTestEnum::with(StringBackedTestEnum::SOME_VALUE);
        $enum2 = StringBackedTestEnum2::with(StringBackedTestEnum2::A_VERY_OTHER_VALUE);
        $this->assertSame(StringBackedTestEnum::SOME_VALUE, (string)$enum1);
        $this->assertSame(StringBackedTestEnum2::A_VERY_OTHER_VALUE, (string)$enum2);
        $this->assertNotSame($enum1, $enum2);
    }

    /**
     * @test
     */
    public function from_differentEnum_differentValue()
    {
        $enum1 = StringBackedTestEnum::from(StringBackedTestEnum::SOME_VALUE);
        $enum2 = StringBackedTestEnum2::from(StringBackedTestEnum2::A_VERY_OTHER_VALUE);
        $this->assertSame(StringBackedTestEnum::SOME_VALUE, (string)$enum1);
        $this->assertSame(StringBackedTestEnum2::A_VERY_OTHER_VALUE, (string)$enum2);
        $this->assertNotSame($enum1, $enum2);
    }

    /**
     * @test
     */
    public function with_differentEnum_sameValue()
    {
        $enum1 = StringBackedTestEnum::with(StringBackedTestEnum::SOME_VALUE);
        $enum2 = StringBackedTestEnum2::with(StringBackedTestEnum2::SOME_VALUE);
        $this->assertSame(StringBackedTestEnum::SOME_VALUE, (string)$enum1);
        $this->assertSame(StringBackedTestEnum2::SOME_VALUE, (string)$enum2);
        $this->assertNotSame($enum1, $enum2);
    }

    /**
     * @test
     */
    public function from_differentEnum_sameValue()
    {
        $enum1 = StringBackedTestEnum::from(StringBackedTestEnum::SOME_VALUE);
        $enum2 = StringBackedTestEnum2::from(StringBackedTestEnum2::SOME_VALUE);
        $this->assertSame(StringBackedTestEnum::SOME_VALUE, (string)$enum1);
        $this->assertSame(StringBackedTestEnum2::SOME_VALUE, (string)$enum2);
        $this->assertNotSame($enum1, $enum2);
    }
}
