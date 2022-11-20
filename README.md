# php-enum - yet another enum handling for PHP
- slim
- easy to use
- memory efficient
- type safe
- IDE type hint safe
- refactoring safe
- tested

```PHP
class SomeEnum extends \Codeup\Enum\Reflection\Enum {
    const SOME_VALUE = 'someValue';
    const ANOTHER_VALUE = 'anotherValue';
}
```

```PHP
$enum1 = SomeEnum::with(SomeEnum::SOME_VALUE);
$enum2 = SomeEnum::with(SomeEnum::SOME_VALUE);
$enum1 === $enum2; // true
```

```PHP
$enum1 = new SomeEnum(SomeEnum::SOME_VALUE);
$enum2 = new SomeEnum(SomeEnum::SOME_VALUE);
$enum1 === $enum2; // false
$enum1->equals($enum2); // true
$enum1->is(SomeEnum::SOME_VALUE); // true
```

## upcoming usage prepared for PHP 8.1 enums (experimental)

Prepares enhancement of native PHP enums by easy string representation handling.

```PHP
class SomeEnum implements \Codeup\Enum\Enum {
    use \Codeup\Enum\StringBacked;

    const SOME_VALUE = 'someValue';
    const ANOTHER_VALUE = 'anotherValue';
}
```

```PHP
$enum1 = SomeEnum::from('SOME_VALUE');
$enum2 = SomeEnum::from('SOME_VALUE');
$enum1 === $enum2; // true
```

```PHP
$enum1 = SomeEnum::SOME_VALUE;
$enum2 = SomeEnum::SOME_VALUE;
$enum1 === $enum2; // true
$enum1->equals($enum2); // true
$enum1->is('SOME_VALUE'); // true
```
