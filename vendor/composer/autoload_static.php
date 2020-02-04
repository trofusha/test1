<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitced9b517c6097b3e29561fd36a640021
{
    public static $classMap = array (
        'BDMysql' => __DIR__ . '/../..' . '/src/DBMysql.class.php',
        'IBD' => __DIR__ . '/../..' . '/src/DBMysql.class.php',
        'Iparser' => __DIR__ . '/../..' . '/src/Parser.class.php',
        'PPrint' => __DIR__ . '/../..' . '/src/PPrint.trait.php',
        'Parser' => __DIR__ . '/../..' . '/src/Parser.class.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitced9b517c6097b3e29561fd36a640021::$classMap;

        }, null, ClassLoader::class);
    }
}