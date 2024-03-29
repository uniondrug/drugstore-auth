<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite7e78f491df54c3c74bf847662c84766
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        '25072dd6e2470089de65ae7bf11d3109' => __DIR__ . '/..' . '/symfony/polyfill-php72/bootstrap.php',
        'e69f7f6ee287b969198c3c9d6777bd38' => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer/bootstrap.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        'f598d06aa772fa33d905e87be6398fb1' => __DIR__ . '/..' . '/symfony/polyfill-intl-idn/bootstrap.php',
        'd0734ab779c34c225af08f27b42bcc41' => __DIR__ . '/..' . '/uniondrug/framework/helpers.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Uniondrug\\ServiceSdk\\' => 21,
            'Uniondrug\\Redis\\' => 16,
            'Uniondrug\\Phar\\' => 15,
            'Uniondrug\\Middleware\\' => 21,
            'Uniondrug\\HttpClient\\' => 21,
            'Uniondrug\\Framework\\' => 20,
            'Uniondrug\\DrugstoreAuth\\' => 24,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Php72\\' => 23,
            'Symfony\\Polyfill\\Intl\\Normalizer\\' => 33,
            'Symfony\\Polyfill\\Intl\\Idn\\' => 26,
            'Symfony\\Component\\Dotenv\\' => 25,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Uniondrug\\ServiceSdk\\' => 
        array (
            0 => __DIR__ . '/..' . '/uniondrug/service-sdk/src',
        ),
        'Uniondrug\\Redis\\' => 
        array (
            0 => __DIR__ . '/..' . '/uniondrug/redis/src',
        ),
        'Uniondrug\\Phar\\' => 
        array (
            0 => __DIR__ . '/..' . '/uniondrug/phar/src',
        ),
        'Uniondrug\\Middleware\\' => 
        array (
            0 => __DIR__ . '/..' . '/uniondrug/middleware/src',
        ),
        'Uniondrug\\HttpClient\\' => 
        array (
            0 => __DIR__ . '/..' . '/uniondrug/http-client/src',
        ),
        'Uniondrug\\Framework\\' => 
        array (
            0 => __DIR__ . '/..' . '/uniondrug/framework/src',
        ),
        'Uniondrug\\DrugstoreAuth\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Symfony\\Polyfill\\Php72\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php72',
        ),
        'Symfony\\Polyfill\\Intl\\Normalizer\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer',
        ),
        'Symfony\\Polyfill\\Intl\\Idn\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-intl-idn',
        ),
        'Symfony\\Component\\Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/dotenv',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Normalizer' => __DIR__ . '/..' . '/symfony/polyfill-intl-normalizer/Resources/stubs/Normalizer.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite7e78f491df54c3c74bf847662c84766::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite7e78f491df54c3c74bf847662c84766::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite7e78f491df54c3c74bf847662c84766::$classMap;

        }, null, ClassLoader::class);
    }
}
