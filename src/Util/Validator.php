<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Util;

use Pancoast\Common\Exception\InvalidArgumentException;
use Pancoast\Common\Util\Exception\NotTraversableException;
use Pancoast\Common\Util\Exception\InvalidTypeArgumentException;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Generic type validator
 *
 * This is a simple PHP type checking helper. It isn't for full-fledged validation like symfony/validator provides (for
 * example). It's more for is_string() like checks but with helpful APIs to allow for multiple types of values to be
 * checked with one call.
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @todo   Add permanent tests (the code has been tested though)
 * @todo   Add self::validateTypeArray()
 */
class Validator
{
    /**
     * Last failure
     *
     * @internal Cannot return this to client since class accessed statically. Only used internally
     */
    private static $lastFailure;

    /**
     * Check if value is of a type
     *
     * You can pass a single value and type or you can pass an array of either. If you want to validate each element of
     * an array (instead of the array itself), make sure to set $traverseValues to true.
     *
     * This method will return true if all values are of any of the types.
     *
     * @param mixed|array|\Traversable $value          Value or array of values of whose types must be one of the
     *                                                 passed $type(s).
     * @param mixed|array|\Traversable $type           Type or array of acceptable types. $value(s) must be one of
     *                                                 these.
     * @param bool                     $traverseValues By default, this method will check the top level structure
     *                                                 passed to $value. Meaning if you passed an array, an array is
     *                                                 what will be validated. Setting this to true allows each of the
     *                                                 array elements to be validated instead (e.g., if you want to
     *                                                 validate that all elements are a string, set this to true).
     *
     * @return bool True if all $value(s) (as based on $traverseValues setting) are of any of $type(s)
     * @throws InvalidTypeArgumentException If type passed is invalid
     * @throws NotTraversableException If $traverseValues is true and $value not traversable
     */
    public static function isType($value, $type, $traverseValues = false)
    {
        self::$lastFailure = null;

        $types = static::isTraversable($type) ? $type : [$type];

        $isValueTraversable = static::isTraversable($value);

        if ($traverseValues && !$isValueTraversable) {
            throw new NotTraversableException('Attempting to traverse a non-traversable $value');
//        } elseif ($isValueTraversable) {
//            $values = [$value];
        } else {
            $values = [$value];
        }

        // loop each passed value, if value matches any of the types, loop to next value.
        // if end reached
        // TODO change this and above so array creation not always necessary
        for ($i = 0, $c = count($values); $i < $c; $i++) {
            $value = $values[$i];

            // all values default to false
            $isValid = false;

            foreach ($types as $type) {
                switch ($type) {
                    case 'null':
                    case null:
                        $isValid = is_null($value);
                        break;
                    case 'object':
                        $isValid = is_object($value);
                        break;
                    case 'array':
                        $isValid = is_array($value);
                        break;
                    // sequential array
                    case 'array_seq':
                        if (!is_array($value)) {
                            $isValid = false;
                            break;
                        }

                        for (reset($arr), $base = 0; key($arr) === $base++; next($arr));
                        $isValid = is_null(key($arr));
                        break;
                    // indexed array
                    case 'array_ind':
                        if (!is_array($value)) {
                            $isValid = false;
                            break;
                        }

                        for (reset($value); is_int(key($value)); next($value));
                        $isValid = is_null(key($value));
                        break;
                    // note that in PHP all arrays are associative in reality. these are just helper
                    // checks that really say "is the array not indexed".
                    case 'hash':
                    case 'assoc':
                    case 'associative':
                        if (!is_array($value)) {
                            $isValid = false;
                            break;
                        }

                        // if value is an array that's not indexed
                        // this is the best check possible in PHP but be aware of
                        // the limitations.
                        $isValid = !static::isType($value, 'array_ind');
                        break;
                    case 'bool':
                    case 'boolean':
                        $isValid = is_bool($value);
                        break;
                    case 'int':
                    case 'integer':
                        $isValid = is_int($value);
                        break;
                    case 'string':
                        $isValid = is_string($value);
                        break;
                    case 'traversable':
                        $isValid = static::isTraversable($value);
                        break;
                    case 'class':
                        $isValid = is_string($value) && class_exists($value);
                        break;
                    case 'interface':
                        $isValid = is_string($value) && interface_exists($value);
                        break;
                    // one final check for type check on class, interface, and trait.
                    // this should only be checked *after* all other type checks
                    // to avoid potential class collisions with the string types (although this is likely not possible
                    // in PHP's parser).
                    case trait_exists($type):
                    case interface_exists($type):
                    case class_exists($type):
                        $isValid = is_object($value) && $value instanceof $type;
                        break;
                    default:
                        // if we got this far the type being checked is invalid
                        throw new InvalidTypeArgumentException(
                            sprintf(
                                '$type must be a valid type or an array of valid types, received [%s].',
                                implode(', ', $types)
                            )
                        );
                }

                // If a value matched any of the acceptable types, it's valid so continue onto the next value.
                if ($isValid) {
                    continue 2;
                }
            }

            // Since all values must match type, if current value didn't match any type,
            // set last failure and return false
            if (!$isValid) {
                if ($traverseValues && static::isTraversable($value)) {
                    self::$lastFailure = sprintf(
                        'Expected all $value(s) to be one of the following types [%s], received type %s at array index %s.',
                        implode(', ', $types),
                        is_object($value) ? get_class($value) : gettype($value),
                        $i
                    );
                } else {
                    self::$lastFailure = sprintf(
                        'Expected $value to be one of the following types [%s], received type %s.',
                        implode(', ', $types),
                        is_object($value) ? get_class($value) : gettype($value)
                    );
                }

                return false;
            }
        }

        // if we made it here, all values match one of the acceptable types
        return true;
    }

    /**
     * Validate a value's type
     *
     * This shares the same API as self::isType($value, $type, $traverseValues) but instead throws an exception if all
     * values are not of one of the acceptable types.
     *
     * @param mixed|array|\Traversable $value          Value or array of values of whose types must of be one of the
     *                                                 passed $type(s).
     * @param mixed|array|\Traversable $type           Type or array of acceptable types. $value(s) must be one of
     *                                                 these.
     * @param bool                     $traverseValues By default, this method will check the top level structure
     *                                                 passed to $value. Meaning if you passed an array, an array is
     *                                                 what will be validated. Setting this to true allows each of the
     *                                                 array elements to be validated instead (e.g., if you want to
     *                                                 validate that all elements are a string, set this to true).
     *
     * @throws InvalidTypeArgumentException If type passed is invalid
     * @throws InvalidArgumentException     If $value does not match type
     * @throws NotTraversableException If $traverseValues is true ad $value not traversable
     * @see Validator::isType()
     */
    public static function validateType($value, $type, $traverseValues = false)
    {
        if (!static::isType($value, $type, $traverseValues)) {
            throw new InvalidArgumentException(self::$lastFailure);
        }
    }

    /**
     * Validate that a $value is of type $type then return it
     *
     * Same as self::validateType() but returns the validated value.
     *
     * @param mixed|array|\Traversable $value          Value or array of values of whose types must of be one of the
     *                                                 passed $type(s).
     * @param mixed|array|\Traversable $type           Type or array of acceptable types. $value(s) must be one of
     *                                                 these.
     * @param bool                     $traverseValues By default, this method will check the top level structure
     *                                                 passed to $value. Meaning if you passed an array, an array is
     *                                                 what will be validated. Setting this to true allows each of the
     *                                                 array elements to be validated instead (e.g., if you want to
     *                                                 validate that all elements are a string, set this to true).
     *
     * @return mixed Your $value that is a valid type
     * @throws InvalidTypeArgumentException If type passed is invalid
     * @throws InvalidArgumentException     If $value does not match type
     * @throws NotTraversableException If $traverseValues is true and $value not traversable
     */
    public static function getValidatedValue($value, $type, $traverseValues = false)
    {
        static::validateType($value, $type, $traverseValues);

        return $value;
    }

    /**
     * Can $value be traversed
     *
     * Although PHP allows you to traverse any object, only arrays and implementations of \Traversable should be
     * considered traversable. Anything else is considered a single type (Meaning object, string, int etc).
     *
     * @param $value
     *
     * @return bool
     */
    public static function isTraversable($value)
    {
        return is_array($value) || $value instanceof \Traversable;
    }
}
