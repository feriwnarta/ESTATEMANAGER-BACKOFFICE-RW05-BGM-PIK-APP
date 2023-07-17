<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdedfcea0bce76ef0b8347489352d043a
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Webpatser\\Uuid\\' => 15,
        ),
        'N' => 
        array (
            'NextG\\RwAdminApp\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Webpatser\\Uuid\\' => 
        array (
            0 => __DIR__ . '/..' . '/webpatser/laravel-uuid/src/Webpatser/Uuid',
        ),
        'NextG\\RwAdminApp\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdedfcea0bce76ef0b8347489352d043a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdedfcea0bce76ef0b8347489352d043a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdedfcea0bce76ef0b8347489352d043a::$classMap;

        }, null, ClassLoader::class);
    }
}
