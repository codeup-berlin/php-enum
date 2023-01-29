<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace Codeup\Enum;

use Codeup\Enum\Reflection\Enum;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;
use ValueError;

enum NativePureEnum1 implements EnhancedNativeEnum
{
    use EnhancedNativeEnumTrait;

    case SOME_VALUE;
    case ANOTHER_VALUE;
}

enum NativePureEnum2 implements EnhancedNativeEnum
{
    use EnhancedNativeEnumTrait;

    case SOME_VALUE;
    case ANOTHER_VALUE;
}

enum NativeBackedEnum1: string implements EnhancedNativeEnum
{
    use EnhancedNativeEnumTrait;

    case SOME_VALUE = 'some value 1';
    case ANOTHER_VALUE = 'another value 1';
}

enum NativeBackedEnum2: string implements EnhancedNativeEnum
{
    use EnhancedNativeEnumTrait;

    case SOME_VALUE = 'some value 2';
    case ANOTHER_VALUE = 'another value 2';
}

enum NativeBackedEnum3: string implements EnhancedNativeEnum
{
    use EnhancedNativeEnumTrait;

    case UNKNOWN_VALUE = 'unknown value';
    case AMBIGUOUS_VALUE = 'ambiguous value';
}

enum NativeBackedEnum4: string implements EnhancedNativeEnum
{
    use EnhancedNativeEnumTrait;

    case AMBIGUOUS_VALUE = 'ambiguous value';
}

class SubsetEnum extends Enum
{
    const SOME_VALUE_1 = NativeBackedEnum1::SOME_VALUE;
}

class PartialCombinedEnum extends Enum
{
    const SOME_VALUE_1 = NativeBackedEnum1::SOME_VALUE;
    const ANOTHER_VALUE_2 = NativeBackedEnum2::ANOTHER_VALUE;
}

class TotalCombinedEnum extends Enum
{
    const SOME_VALUE_1 = NativeBackedEnum1::SOME_VALUE;
    const ANOTHER_VALUE_1 = NativeBackedEnum1::ANOTHER_VALUE;
    const SOME_VALUE_2 = NativeBackedEnum2::SOME_VALUE;
    const ANOTHER_VALUE_2 = NativeBackedEnum2::ANOTHER_VALUE;
}

class PartialCombinedPureEnum extends Enum
{
    const SOME_VALUE_1 = NativePureEnum1::SOME_VALUE;
    const ANOTHER_VALUE_2 = NativePureEnum2::ANOTHER_VALUE;
}

class StringOnlyEnum extends Enum
{
    const SOMETHING_ELSE = 'something else';
}

class MixedEnum1 extends Enum
{
    const SOME_VALUE = NativeBackedEnum1::SOME_VALUE;
    const SOMETHING_ELSE = 'something else';
}

class MixedEnumNative extends Enum
{
    const SOME_VALUE = NativeBackedEnum1::SOME_VALUE;
    const ANOTHER_VALUE = NativePureEnum1::ANOTHER_VALUE;
}

class MixedEnumPureNativeDuplicate extends Enum
{
    const SOME_VALUE_1 = NativePureEnum1::SOME_VALUE;
    const SOME_VALUE_2 = NativePureEnum2::SOME_VALUE;
}

class SameEnumConflictingEnum extends Enum
{
    const SOME_VALUE = NativeBackedEnum1::SOME_VALUE;
    const SAME_VALUE = NativeBackedEnum1::SOME_VALUE;
}

class AmbiguousValueEnum extends Enum
{
    const SOME_VALUE = NativeBackedEnum3::AMBIGUOUS_VALUE;
    const SAME_VALUE = NativeBackedEnum4::AMBIGUOUS_VALUE;
}

class EnumTest extends TestCase
{
    /**
     * @test
     */
    public function from_validString()
    {
        $enum = SubsetEnum::from('some value 1');
        $this->assertInstanceOf(SubsetEnum::class, $enum);
        $this->assertSame('some value 1', $enum->value);
        $this->assertSame('some value 1', $enum->asString());
        $this->assertSame(SubsetEnum::SOME_VALUE_1, $enum->case);
        $this->assertSame(SubsetEnum::SOME_VALUE_1, $enum->asEnum());
    }

    /**
     * @test
     */
    public function from_validEnum()
    {
        $enum = SubsetEnum::from(NativeBackedEnum1::SOME_VALUE);
        $this->assertInstanceOf(SubsetEnum::class, $enum);
        $this->assertSame('some value 1', $enum->value);
        $this->assertSame('some value 1', $enum->asString());
        $this->assertSame(SubsetEnum::SOME_VALUE_1, $enum->case);
        $this->assertSame(SubsetEnum::SOME_VALUE_1, $enum->asEnum());
    }

    /**
     * @test
     */
    public function from_invalidString()
    {
        $this->expectException(ValueError::class);
        SubsetEnum::from('unknown');
    }

    /**
     * @test
     */
    public function from_invalidEnum()
    {
        $this->expectException(ValueError::class);
        SubsetEnum::from(NativeBackedEnum3::UNKNOWN_VALUE);
    }

    /**
     * @test
     */
    public function from_sameInstance()
    {
        $enum1 = SubsetEnum::from('some value 1');
        $enum2 = SubsetEnum::from('some value 1');
        $this->assertSame($enum1, $enum2);
    }

    /**
     * @test
     */
    public function tryFrom_validString()
    {
        $enum = SubsetEnum::tryFrom('some value 1');
        $this->assertInstanceOf(SubsetEnum::class, $enum);
        $this->assertSame('some value 1', $enum->value);
        $this->assertSame('some value 1', $enum->asString());
        $this->assertSame(SubsetEnum::SOME_VALUE_1, $enum->case);
        $this->assertSame(SubsetEnum::SOME_VALUE_1, $enum->asEnum());
    }

    /**
     * @test
     */
    public function tryFrom_validEnum()
    {
        $enum = SubsetEnum::tryFrom(NativeBackedEnum1::SOME_VALUE);
        $this->assertInstanceOf(SubsetEnum::class, $enum);
        $this->assertSame('some value 1', $enum->value);
        $this->assertSame('some value 1', $enum->asString());
        $this->assertSame(SubsetEnum::SOME_VALUE_1, $enum->case);
        $this->assertSame(SubsetEnum::SOME_VALUE_1, $enum->asEnum());
    }

    /**
     * @test
     */
    public function tryFrom_invalidString()
    {
        $result = SubsetEnum::tryFrom('unknown');
        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function tryFrom_invalidEnum()
    {
        $result = SubsetEnum::tryFrom(NativeBackedEnum3::UNKNOWN_VALUE);
        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function tryFrom_sameInstance()
    {
        $enum1 = SubsetEnum::tryFrom('some value 1');
        $enum2 = SubsetEnum::tryFrom('some value 1');
        $this->assertSame($enum1, $enum2);
    }

    /**
     * @return array[][]
     */
    public function provideEnumValues(): array
    {
        return [
            'SubsetEnum' => [SubsetEnum::class, [
                'some value 1'
            ]],
            'PartialCombinedEnum' => [PartialCombinedEnum::class, [
                'some value 1', 'another value 2'
            ]],
            'PartialCombinedPureEnum' => [PartialCombinedPureEnum::class, [
                'SOME_VALUE', 'ANOTHER_VALUE'
            ]],
            'MixedEnumNative' => [MixedEnumNative::class, [
                'some value 1', 'ANOTHER_VALUE'
            ]],
            'TotalCombinedEnum' => [TotalCombinedEnum::class, [
                'some value 1', 'another value 1', 'some value 2', 'another value 2'
            ]],
        ];
    }

    /**
     * @return array[][]
     */
    public function provideEnumCases(): array
    {
        return [
            'SubsetEnum' => [SubsetEnum::class, [
                SubsetEnum::SOME_VALUE_1
            ]],
            'PartialCombinedEnum' => [PartialCombinedEnum::class, [
                PartialCombinedEnum::SOME_VALUE_1,
                PartialCombinedEnum::ANOTHER_VALUE_2
            ]],
            'TotalCombinedEnum' => [TotalCombinedEnum::class, [
                TotalCombinedEnum::SOME_VALUE_1,
                TotalCombinedEnum::ANOTHER_VALUE_1,
                TotalCombinedEnum::SOME_VALUE_2,
                TotalCombinedEnum::ANOTHER_VALUE_2,
            ]],
        ];
    }

    /**
     * @return Enum[]
     */
    public function provideInvalidEnums(): array
    {
        return [
            'StringOnlyEnum' => [StringOnlyEnum::class],
            'MixedEnum1' => [MixedEnum1::class],
            'MixedEnumPureNativeDuplicate' => [MixedEnumPureNativeDuplicate::class],
            'SameEnumConflictingEnum' => [SameEnumConflictingEnum::class],
            'AmbiguousValueEnum' => [AmbiguousValueEnum::class],
        ];
    }

    /**
     * @test
     * @dataProvider provideEnumValues
     */
    public function values_valid(string $enumClass, array $expectedValues)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $values = $enumClass::values();
        $this->assertSame($expectedValues, $values);
    }

    /**
     * @test
     * @dataProvider provideInvalidEnums
     */
    public function values_invalid(string $enumClass)
    {
        $this->expectException(UnexpectedValueException::class);
        /** @noinspection PhpUndefinedMethodInspection */
        $enumClass::values();
    }

    /**
     * @test
     * @dataProvider provideEnumCases
     */
    public function cases_valid(string $enumClass, array $expectedCases)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $cases = $enumClass::cases();
        $this->assertSame($expectedCases, $cases);
    }

    /**
     * @test
     * @dataProvider provideInvalidEnums
     */
    public function cases_invalid(string $enumClass)
    {
        $this->expectException(UnexpectedValueException::class);
        /** @noinspection PhpUndefinedMethodInspection */
        $enumClass::cases();
    }

    /**
     * @test
     */
    public function equals_matchingString()
    {
        $enum = TotalCombinedEnum::from(TotalCombinedEnum::SOME_VALUE_1);
        $result = $enum->equals('some value 1');
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function equals_matchingBackedEnum()
    {
        $enum = TotalCombinedEnum::from(TotalCombinedEnum::SOME_VALUE_1);
        $result = $enum->equals(NativeBackedEnum1::SOME_VALUE);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function equals_matchingEnum()
    {
        $enum = TotalCombinedEnum::from(TotalCombinedEnum::SOME_VALUE_1);
        $enum2 = TotalCombinedEnum::from(TotalCombinedEnum::SOME_VALUE_1);
        $result = $enum->equals($enum2);
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function equals_differentString()
    {
        $enum = TotalCombinedEnum::from(TotalCombinedEnum::SOME_VALUE_1);
        $result = $enum->equals('another value');
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function equals_differentBackedEnum()
    {
        $enum = TotalCombinedEnum::from(TotalCombinedEnum::SOME_VALUE_1);
        $result = $enum->equals(NativeBackedEnum1::ANOTHER_VALUE);
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function equals_differentEnum()
    {
        $enum = TotalCombinedEnum::from(TotalCombinedEnum::SOME_VALUE_1);
        $enum2 = TotalCombinedEnum::from(TotalCombinedEnum::SOME_VALUE_2);
        $result = $enum->equals($enum2);
        $this->assertFalse($result);
    }
}
