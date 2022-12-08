<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace Codeup\Enum;

use Codeup\Enum\Reflection\Enum;
use PHPUnit\Framework\TestCase;

enum NativeEnum: string implements EnhancedNativeEnum {
    use EnhancedNativeEnumTrait;

    case SOME_VALUE = 'some value';
    case ANOTHER_VALUE = 'another value';
}

enum DifferentNativeEnum: string implements EnhancedNativeEnum {
    use EnhancedNativeEnumTrait;

    case DIFFERENT_VALUE = 'different value';
}

class PartialEnum extends Enum
{
    const SOME_VALUE = NativeEnum::SOME_VALUE;
    const DIFFERENT_VALUE = DifferentNativeEnum::DIFFERENT_VALUE;
}

class EnhancedNativeEnumTraitTest extends TestCase
{
    /**
     * @test
     */
    public function values_valid()
    {
        $this->assertSame(['some value', 'another value'], NativeEnum::values());
    }

    /**
     * @test
     */
    public function equals_matchingString()
    {
        $enum = NativeEnum::SOME_VALUE;
        $result = $enum->equals('some value');
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function equals_matchingBackedEnum()
    {
        $enum = NativeEnum::SOME_VALUE;
        $result = $enum->equals(NativeEnum::SOME_VALUE);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function equals_matchingEnum()
    {
        $enum = NativeEnum::SOME_VALUE;
        $enum2 = PartialEnum::from(NativeEnum::SOME_VALUE);
        $result = $enum->equals($enum2);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function equals_differentString()
    {
        $enum = NativeEnum::SOME_VALUE;
        $result = $enum->equals('unknown');
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function equals_differentBackedEnum()
    {
        $enum = NativeEnum::SOME_VALUE;
        $result = $enum->equals(NativeEnum1::ANOTHER_VALUE);
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function equals_differentEnum()
    {
        $enum = NativeEnum::SOME_VALUE;
        $enum2 = PartialEnum::from(DifferentNativeEnum::DIFFERENT_VALUE);
        $result = $enum->equals($enum2);
        $this->assertFalse($result);
    }
}
