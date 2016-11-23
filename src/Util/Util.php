<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2016 John Pancoast
 * @license       MIT
 */

namespace Pancoast\CodeChallenge;

/**
 * Helper util
 *
 * This should only contain the generic utility/helper functionality
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class Util
{
    /**
     * Helper to validate that a value for a field is of a certain type
     *
     * @param mixed $value
     * @param mixed $type
     * @param null $field
     *
     * @throws \InvalidArgumentException If value not expected type
     */
    public static function validateType($value, $type, $field = null)
    {
        $isValid = false;

        switch ($type) {
            case 'array':
                $isValid = is_array($value);
                break;
            case 'bool':
                $isValid = is_bool($value);
                break;
            case 'int':
                $isValid = is_int($value);
                break;
            case 'string':
                $isValid = is_string($value);
                break;
        }

        if (!$isValid) {
            if ($field) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Expected type %s for "%s". Received value "%s".',
                        $type,
                        $field,
                        $value
                    )
                );
            } else {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Expected type %s. Received value "%s".',
                        $type,
                        $value
                    )
                );
            }
        }
    }
}
