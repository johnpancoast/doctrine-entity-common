<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\Common\Util;

/**
 * Helper util
 *
 * This should only contain the generic utility/helper functionality
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 * @todo I'm sure the logic here can be fixed up but it works
 */
class Util
{
    /**
     * Is $value of $type
     *
     * @param mixed         $value
     * @param string|array  $type or an array of acceptable types
     *
     * @return bool
     */
    public static function isType($value, $type)
    {
        // return value
        $isValid = false;

        // allow $type to be an array of types or create as array
        $types = is_array($type) ? $type : [$type];

        foreach ($types as $t) {
            // are we checking that $value is an instance of $type?
            // this should only be checked *after* all other type checks
            // to avoid potential class collisions with the string types
            $typeIsClass = class_exists($t);

            switch ($t) {
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
                default:
                    // one final check for type check on class
                    if ($typeIsClass) {
                        $isValid = is_object($value) && $value instanceof $t;
                        break;
                    }

                    // if we got this far, the user passed the wrong type
                    throw new \InvalidArgumentException('$type must be a valid type or an array of valid types');
            }

            if (!$isValid) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate that a $value is of type $type
     *
     * @param mixed $value
     * @param string|array $type
     *
     * @throws \InvalidArgumentException
     */
    public static function validateType($value, $type)
    {
        if (!self::isType($value, $type)) {
            // normalize the types for printing
            $printTypes = array_map(function($t){
                switch ($t) {
                    case null:
                        return 'null';
                    case class_exists($t):
                        return sprintf("'%s'", $t);
                    default:
                        return $t;
                }
            }, is_array($type) ? $type : [$type]);

            throw new \InvalidArgumentException(sprintf(
                '$value expected to be one of type [%s]. Received type %s.',
                implode(', ', $printTypes),
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }
    }

    /**
     * Validate that several values are of types
     *
     * Note that we had to do the reverse of the other methods here because of PHPs RIDICULOUS handling or numeric
     * array keys.
     *
     * array e.g.,
     * [
     *      'type' => 'value',
     *      'type' => 'value',
     *      ...
     * ]
     *
     * @param array $valueTypes
     *
     * @throws \InvalidArgumentException
     */
    public static function validateTypes(array $valueTypes = [])
    {
        foreach ($valueTypes as $type => $value) {
            static::validateType($value, $type);
        }
    }
}
