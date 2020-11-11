# php-enum - yet another enum handling for PHP
- slim
- easy to use
- memory efficient
- type safe
- IDE type hint safe
- refactoring safe
- tested

```
class SomeEnum extends \Codeup\Enum\Reflection\Enum {
    const SOME_VALUE = 'someValue';
    const ANOTHER_VALUE = 'anotherValue';
}
```
```
$enum1 = SomeEnum::with(SomeEnum::SOME_VALUE);
$enum2 = SomeEnum::with(SomeEnum::SOME_VALUE);
$enum1 === $enum2; // true
```
```
$enum1 = new SomeEnum(SomeEnum::SOME_VALUE);
$enum2 = new SomeEnum(SomeEnum::SOME_VALUE);
$enum1 === $enum2; // false
$enum1->equals($enum2); // true
$enum1->is(SomeEnum::SOME_VALUE); // true
```
