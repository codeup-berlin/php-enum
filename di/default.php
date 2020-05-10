<?php /** @noinspection PhpFullyQualifiedNameUsageInspection */

if (!defined('DEBUG')) define('DEBUG', 'DEBUG');

/**
 * @return array
 */
function php_enum_di_default()
{
    $diConfig = [];

    $diConfig[\Codeup\Enum\EnumRegistry::class] = [
        'shared' => true,
        'className' => \Codeup\Enum\Standard\EnumRegistry::class,
    ];

    return $diConfig;
};
return php_enum_di_default();
