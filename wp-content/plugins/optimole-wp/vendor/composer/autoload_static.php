<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbf2c9f2ba560853efcfe306b4c79ac63
{
    public static $files = array (
        '9fef4034ed73e26a337d9856ea126f7f' => __DIR__ . '/..' . '/codeinwp/themeisle-sdk/load.php',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitbf2c9f2ba560853efcfe306b4c79ac63::$classMap;

        }, null, ClassLoader::class);
    }
}
