<?php

namespace Codeup\Enum\Reflection;

class TestEnum extends Enum {
    const SOME_VALUE = 'some value';
    const ANOTHER_VALUE = 'another value';
    const INT_VALUE = 42;
    const FALSE_VALUE = false;
    const TRUE_VALUE = true;
    const FLOAT_VALUE = 1.23;
}

class TestEnum2 extends Enum {
    const SOME_VALUE = 'some other value';
}

class EnumTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function __construct_invalid()
    {
        $this->expectException(\DomainException::class);
        new TestEnum('unknown');
    }

    /**
     * @test
     */
    public function __construct_validStringEnum()
    {
        $enum1 = new TestEnum(TestEnum::SOME_VALUE);
        $enum2 = new TestEnum2(TestEnum2::SOME_VALUE);
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
    public function equals_equalValues($enumValue)
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
     * @dataProvider provideTestEnumValues
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
}
