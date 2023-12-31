<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit0790e77c91e191ab042e6a0b61ae842c
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit0790e77c91e191ab042e6a0b61ae842c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit0790e77c91e191ab042e6a0b61ae842c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit0790e77c91e191ab042e6a0b61ae842c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
