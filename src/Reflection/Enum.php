<?php

declare(strict_types=1);

namespace Codeup\Enum\Reflection;

use Codeup\Enum\BaseEnum;

/**
 * @deprecated in favor of interface Enum and trait StringBackedEnum, will be removed with PHP 8.1 native enum support
 */
class Enum extends BaseEnum implements \Codeup\Enum\Enum
{
    use EnumTrait;
}
