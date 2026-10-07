<?php
/*
 * Minimal, dependency-free PSR-4 autoloader for the sabre/vobject (and its
 * sabre/xml, sabre/uri) source trees that are vendored under externals/sabre.
 *
 * This replaces the previous requirement of running "composer install" in
 * the externals/ directory to generate externals/vendor/autoload.php. Since
 * the full source of sabre/vobject, sabre/xml and sabre/uri is already
 * checked into this repository, no Composer step (and no network access) is
 * required to use this plugin - simply copying the plugin folder is enough.
 *
 * Only the class-loading mechanism is replaced; the sabre/* library code
 * itself is unmodified.
 */

defined('BLUDIT') || die('That did not work as expected.');

spl_autoload_register(function ($class) {
    static $prefixes = array(
        'Sabre\\VObject\\' => '/sabre/vobject/lib/',
        'Sabre\\Xml\\'     => '/sabre/xml/lib/',
        'Sabre\\Uri\\'     => '/sabre/uri/lib/',
    );

    foreach ($prefixes as $prefix => $relativeDir) {
        $prefixLength = strlen($prefix);
        if (strncmp($prefix, $class, $prefixLength) !== 0) {
            continue;
        }
        $relativeClass = substr($class, $prefixLength);
        $file = __DIR__ . $relativeDir . str_replace('\\', '/', $relativeClass) . '.php';
        if (is_file($file)) {
            require $file;
        }
        return;
    }
});
