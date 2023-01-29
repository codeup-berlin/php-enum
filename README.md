# php-enum - enhanced PHP enum handling

```PHP
enum NativeBackedEnum1: string implements \Codeup\Enum\EnhancedNativeEnum {
    use \Codeup\Enum\EnhancedNativeEnumTrait;

    const SOME_VALUE = 'someValue';
    const ANOTHER_VALUE = 'anotherValue';
}
enum NativeBackedEnum2: string implements \Codeup\Enum\EnhancedNativeEnum {
    use \Codeup\Enum\EnhancedNativeEnumTrait;

    const FURTHER_VALUE = 'furtherValue';
}
class PartialEnum extends \Codeup\Enum\Reflection\Enum {
    const SOME_VALUE = NativeBackedEnum1::SOME_VALUE;
}
class CombinedEnum extends \Codeup\Enum\Reflection\Enum {
    const SOME_VALUE = NativeBackedEnum1::SOME_VALUE;
    const ANOTHER_VALUE = NativeBackedEnum1::ANOTHER_VALUE;
    const FURTHER_VALUE = NativeBackedEnum2::FURTHER_VALUE;
}
```

```PHP
$enum1 = NativeBackedEnum1::SOME_VALUE;
$enum2 = NativeBackedEnum1::SOME_VALUE;
$enum1 === $enum2; // true
$enum1->equals('someValue'); // true
$enum1->equals($enum2); // true
```

```PHP
$values = NativeBackedEnum1::values(); // ['someValue', 'anotherValue']
```

```PHP
$values = CombinedEnum::values(); // ['someValue', 'anotherValue', 'furtherValue']
```

```PHP
$enum1 = PartialEnum::from('someValue');
$enum2 = PartialEnum::from(PartialEnum::SOME_VALUE);
$enum1 === $enum2; // true
```
