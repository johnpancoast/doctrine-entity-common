<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\Util;

/**
 * A cached validator will only validate a value against a type once and return the cached response otherwise
 *
 * This is especially helpful for large class hierarchies who may be validating the same values over and over.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class CachedValidator extends Validator
{
    /**
     * @var array
     */
    private static $cache = [];

    /**
     * Check if value is of a type
     *
     * This is the same as parent::isType() but caches the results
     *
     * @param array|mixed|\Traversable $value
     * @param array|mixed|\Traversable $type
     * @param bool                     $traverseValues
     * @param bool                     $useCache
     *
     * @return bool
     * @throws \Pancoast\Common\Util\Exception\InvalidTypeArgumentException
     * @throws \Pancoast\Common\Util\Exception\NotTraversableException
     */
    public static function isType($value, $type, $traverseValues = false, $useCache = true)
    {
        $args = func_get_args();
        unset($args[3]);
        $key = serialize($args);

        if (!isset(self::$cache[$key]) || !$useCache) {
            self::$cache[$key] = parent::isType($value, $type, $traverseValues);
        }

        return self::$cache[$key];
    }
}
