<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace Codeup\Enum;

use Codeup\Enum\Reflection\Enum;
use PHPUnit\Framework\TestCase;

enum NativePureEnum implements EnhancedNativeEnum {
    use EnhancedNativeEnumTrait;

    case SOME_VALUE;
    case ANOTHER_VALUE;
}

enum NativeBackedEnum: string implements EnhancedNativeEnum {
    use EnhancedNativeEnumTrait;

    case SOME_VALUE = 'some value';
    case ANOTHER_VALUE = 'another value';
}

enum DifferentNativeBackedEnum: string implements EnhancedNativeEnum {
    use EnhancedNativeEnumTrait;

    case DIFFERENT_VALUE = 'different value';
}

class PartialEnum extends Enum
{
    const SOME_VALUE = NativeBackedEnum::SOME_VALUE;
    const DIFFERENT_VALUE = DifferentNativeBackedEnum::DIFFERENT_VALUE;
}

class EnhancedNativeEnumTraitTest extends TestCase
{
    /**
     * @test
     */
    public function value_pureEnum()
    {
        $this->assertSame('SOME_VALUE', NativePureEnum::SOME_VALUE->value());
    }

    /**
     * @test
     */
    public function value_backedEnum()
    {
        $this->assertSame('some value', NativeBackedEnum::SOME_VALUE->value());
    }

    /**
     * @test
     */
    public function values_pureEnum()
    {
        $this->assertSame(['SOME_VALUE', 'ANOTHER_VALUE'], NativePureEnum::values());
    }

    /**
     * @test
     */
    public function values_backedEnum()
    {
        $this->assertSame(['some value', 'another value'], NativeBackedEnum::values());
    }

    /**
     * @test
     */
    public function equals_pureEnumMatchesPureValue()
    {
        $enum = NativePureEnum::SOME_VALUE;
        $result = $enum->equals('SOME_VALUE');
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function equals_backedEnumMatchesBackedValue()
    {
        $enum = NativeBackedEnum::SOME_VALUE;
        $result = $enum->equals('some value');
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function equals_backedEnumMatchesPureValue_notEquals()
    {
        $enum = NativeBackedEnum::SOME_VALUE;
        $result = $enum->equals('SOME_VALUE');
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function equals_backedEnumMatchesBackedEnum()
    {
        $enum = NativeBackedEnum::SOME_VALUE;
        $result = $enum->equals(NativeBackedEnum::SOME_VALUE);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function equals_backedEnumMatchesEnum()
    {
        $enum = NativeBackedEnum::SOME_VALUE;
        $enum2 = PartialEnum::from(NativeBackedEnum::SOME_VALUE);
        $result = $enum->equals($enum2);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function equals_backedEnumDifferentValue()
    {
        $enum = NativeBackedEnum::SOME_VALUE;
        $result = $enum->equals('unknown');
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function equals_backedEnumDifferentBackedEnum()
    {
        $enum = NativeBackedEnum::SOME_VALUE;
        $result = $enum->equals(NativeBackedEnum1::ANOTHER_VALUE);
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function equals_differentEnum()
    {
        $enum = NativeBackedEnum::SOME_VALUE;
        $enum2 = PartialEnum::from(DifferentNativeBackedEnum::DIFFERENT_VALUE);
        $result = $enum->equals($enum2);
        $this->assertFalse($result);
    }
}
