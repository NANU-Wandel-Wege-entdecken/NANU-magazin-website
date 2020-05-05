<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit721b4d9fead4dc46f7281940d3abad31
{
    public static $files = array (
        '9c95751f608974ecf91956497ba108e9' => __DIR__ . '/../..' . '/inc/Helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'Nanu\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Nanu\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit721b4d9fead4dc46f7281940d3abad31::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit721b4d9fead4dc46f7281940d3abad31::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
