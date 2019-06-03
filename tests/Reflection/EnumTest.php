<?php

namespace Codeup\Enum\Reflection;

use DomainException;
use PHPUnit\Framework\TestCase;

class TestEnum extends Enum {
    const SOME_VALUE = 'some value';
    const ANOTHER_VALUE = 'another value';
    const INT_VALUE = 42;
    const FALSE_VALUE = false;
    const TRUE_VALUE = true;
    const FLOAT_VALUE = 1.23;
}

class TestEnum2 extends Enum {
    const SOME_VALUE = 'some value';
    const ANOTHER_VALUE = 'another value';
    const INT_VALUE = 42;
    const FALSE_VALUE = false;
    const TRUE_VALUE = true;
    const FLOAT_VALUE = 1.23;
    //
    const SOME_OTHER_VALUE = 'some other value';
}

class EnumTest extends TestCase
{
    /**
     * @test
     */
    public function __construct_invalid()
    {
        $this->expectException(DomainException::class);
        new TestEnum('unknown');
    }

    /**
     * @test
     */
    public function __construct_validStringEnum()
    {
        $enum1 = new TestEnum(TestEnum::SOME_VALUE);
        $enum2 = new TestEnum2(TestEnum2::SOME_OTHER_VALUE);
        $this->assertNotEquals($enum1, $enum2);
    }

    /**
     * @return array
     */
    public function provideTestEnumValues(): array
    {
        return [
            'string' => [TestEnum::SOME_VALUE],
            'int' => [TestEnum::INT_VALUE],
            'false' => [TestEnum::FALSE_VALUE],
            'true' => [TestEnum::TRUE_VALUE],
            'float' => [TestEnum::FLOAT_VALUE],
        ];
    }

    /**
     * @test
     * @dataProvider provideTestEnumValues
     * @param string|int|bool|float $enumValue
     */
    public function is_validEnum($enumValue)
    {
        // prepare
        $enum = new TestEnum($enumValue);
        // test
        $result = $enum->is($enumValue);
        // verify
        $this->assertTrue($result);
    }

    /**
     * @test
     * @dataProvider provideTestEnumValues
     * @param string|int|bool|float $enumValue
     */
    public function __toString_validEnum($enumValue)
    {
        // prepare
        $enum = new TestEnum($enumValue);
        // test
        $result = $enum->__toString();
        // verify
        $this->assertSame('' . $enumValue, $result);
    }

    /**
     * @test
     * @dataProvider provideTestEnumValues
     * @param string|int|bool|float $enumValue
     */
    public function equals_sameInstance($enumValue)
    {
        // prepare
        $enum = new TestEnum($enumValue);
        // test
        $result = $enum->equals($enum);
        // verify
        $this->assertTrue($result);
    }

    /**
     * @test
     * @dataProvider provideTestEnumValues
     * @param string|int|bool|float $enumValue
     */
    public function equals_sameValuesSameClasses($enumValue)
    {
        // prepare
        $enum1 = new TestEnum($enumValue);
        $enum2 = new TestEnum($enumValue);
        // test
        $result = $enum1->equals($enum2);
        // verify
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function equals_differentValues()
    {
        // prepare
        $enum1 = new TestEnum(TestEnum::SOME_VALUE);
        $enum2 = new TestEnum(TestEnum::ANOTHER_VALUE);
        // test
        $result = $enum1->equals($enum2);
        // verify
        $this->assertFalse($result);
    }

    /**
     * @test
     * @dataProvider provideTestEnumValues
     * @param string|int|bool|float $enumValue
     */
    public function equals_sameValuesDifferentClasses($enumValue)
    {
        // prepare
        $enum1 = new TestEnum($enumValue);
        $enum2 = new TestEnum2($enumValue);
        // test
        $result = $enum1->equals($enum2);
        // verify
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function getEnumValues()
    {
        // prepare
        $expectedResult1 = [
            (string)TestEnum::SOME_VALUE,
            (string)TestEnum::ANOTHER_VALUE,
            (string)TestEnum::INT_VALUE,
            (string)TestEnum::FALSE_VALUE,
            (string)TestEnum::TRUE_VALUE,
            (string)TestEnum::FLOAT_VALUE,
        ];
        $expectedResult2 = [
            (string)TestEnum2::SOME_VALUE,
            (string)TestEnum2::ANOTHER_VALUE,
            (string)TestEnum2::INT_VALUE,
            (string)TestEnum2::FALSE_VALUE,
            (string)TestEnum2::TRUE_VALUE,
            (string)TestEnum2::FLOAT_VALUE,
            (string)TestEnum2::SOME_OTHER_VALUE,
        ];
        // test
        $result1 = TestEnum::getEnumValues();
        $result2 = TestEnum2::getEnumValues();
        // verify
        $this->assertSame($result1, $expectedResult1);
        $this->assertSame($result2, $expectedResult2);
    }
}
