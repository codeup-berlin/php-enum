<?php

declare(strict_types=1);

namespace Codeup\Enum;

/**
 * @internal
 * @deprecated in favor of interface Enum and trait StringBacked, will be removed with PHP 8.1 native enum support
 */
abstract class BaseEnum implements Enum
{
    use BaseEnumTrait;
}
