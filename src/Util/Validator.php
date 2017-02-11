<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Util;

use Pancoast\Common\Exception\InvalidArgumentException;
use Pancoast\Common\Util\Exception\InvalidTypeArgumentException;

/**
 * Generic type validator
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @todo   This desperately needs tests
 * @todo   Add self::validateTypeArray()
 */
class Validator
{
    /**
     * @var null|string
     */
    protected static $lastFailure;

    /**
     * Check if value is of a type
     *
     * You can pass a single value and type or you can pass an array of either. This method will return true if all
     * values passed are of any of the passed types.
     *
     * Since this only returns a boolean you can use self::getLastFailure()} to get the last failure message.
     *
     * @param mixed|array|\Traversable $value          Value or array of values of whose types must be one of the
     *                                                 passed $type(s).
     * @param mixed|array|\Traversable $type           Type or array of acceptable types. $value(s) must be one of
     *                                                 these.
     * @param bool                     $traverseValues By default, if you pass a traversable value to $value, each
     *                                                 value will be validated against any of the types passed in
     *                                                 $type. But sometimes, you just want to check the main type of
     *                                                 $value without traversing, even if it's a traversable. Setting
     *                                                 this to false allows that.
     *
     * @return bool True if all $value(s) are of any of $type(s)
     * @throws InvalidTypeArgumentException If type passed is invalid
     */
    public static function isType($value, $type, $traverseValues = true)
    {
        // clear last failure before starting
        static::$lastFailure = null;

        // Change type so that all are looped below regardless of passed args
        $types = static::isTraversable($type) ? $type : [$type];

        // Similar to types, do the same with values but take into consideration the $traverseValues arg. The goal being
        // to make structures that work for all cases below.
        if ($traverseValues) {
            $values = static::isTraversable($value) ? $value : [$value];
        } else {
            // if not traversing values but an array was passed as value, put it into an array so as to not traverse the
            // elements but instead validate the top level structure itself.
            $values = is_array($value) ? [$value] : $value;
        }

        // loop each passed value, if value matches any of the types, loop to next value.
        // if end reached
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
                if (count($values) > 1) {
                    static::$lastFailure = sprintf(
                        'Expected $value(s) to be one of the following types [%s], received type %s at array index %s.',
                        implode(', ', $types),
                        is_object($value) ? get_class($value) : gettype($value),
                        $i
                    );
                } else {
                    static::$lastFailure = sprintf(
                        'Expected $value(s) to be one of the following types [%s], received type %s.',
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
     * Validate that a value is of a type
     *
     * This shares the same API as self::isType($value, $type, $traverseValues) but instead throws an exception if all
     * values are not of one of the acceptable types.
     *
     * @param mixed|array|\Traversable $value          Value or array of values of whose types must of be one of the
     *                                                 passed $type(s).
     * @param mixed|array|\Traversable $type           Type or array of acceptable types. $value(s) must be one of
     *                                                 these.
     * @param bool                     $traverseValues By default, if you pass a traversable value to $value, each
     *                                                 value will be validated against any of the types passed in
     *                                                 $type. But sometimes, you just want to check the main type of
     *                                                 $value without traversing, even if it's a traversable. Setting
     *                                                 this to false allows that.
     *
     * @throws InvalidTypeArgumentException If type passed is invalid
     * @throws InvalidArgumentException     If $value does not match type
     * @see self::isType()
     */
    public static function validateType($value, $type, $traverseValues = true)
    {
        if (!static::isType($value, $type, $traverseValues)) {
            throw new InvalidArgumentException(static::$lastFailure);
        }
    }

    /**
     * Validate that a $value is of type $type then return it
     *
     * This shares the same API as self->isType($value, $type, $traverseValues) but instead throws an exception if all
     * values are not one of the acceptable types.
     *
     * @param mixed|array|\Traversable $value          Value or array of values of whose types must of be one of the
     *                                                 passed $type(s).
     * @param mixed|array|\Traversable $type           Type or array of acceptable types. $value(s) must be one of
     *                                                 these.
     * @param bool                     $traverseValues By default, if you pass a traversable value to $value, each
     *                                                 value will be validated against any of the types passed in
     *                                                 $type. But sometimes, you just want to check the main type of
     *                                                 $value without traversing, even if it's a traversable. Setting
     *                                                 this to false allows that.
     *
     * @return mixed Your $value that is a valid type
     * @throws InvalidTypeArgumentException If type passed is invalid
     * @throws InvalidArgumentException     If $value does not match type
     */
    public static function getValidatedValue($value, $type, $traverseValues = true)
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

    /**
     * Get last invalid value
     *
     * Note that this is cleared each time you run static::isType()
     *
     * @return null|string
     */
    public static function getLastFailure()
    {
        return static::$lastFailure;
    }
}