<?php
/**
 * @package       johnpancoast/goalie-backend
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 */

namespace Pancoast\Common\ObjectRegistry;

use Pancoast\Common\Exception\InvalidArgumentException;
use Pancoast\Common\Exception\LogicException;
use Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotSupportedException;
use Pancoast\Common\ObjectRegistry\Exception\ObjectNotSupportedException;
use Pancoast\Common\Util\Validator;

/**
 * A simple registry that can hold any number of known types of object by key.
 *
 * See the docs in KnownObjectRegistryInterface::getSupportedTypes() for details on how to find or define the
 * objects that a registry supports.
 *
 * @see    KnownObjectRegistryInterface::getSupportedTypes()
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
abstract class AbstractKnownObjectRegistry extends ObjectRegistry implements KnownObjectRegistryInterface
{
    /**
     * Supported types
     *
     * Use static::getSupportedTypes() to get the types.
     *
     * @var null|array
     * @see static::getSupportedTypes()
     */
    private static $types;

    /**
     * Return the same array expected by KnownObjectRegistryInterface::getSupportedTypes()
     *
     * This should be considered abstract (although it's static so can't be defined as such) and must be defined by any
     * children of this class.
     *
     * @see KnownObjectRegistryInterface::getSupportedTypes()
     * @return array
     * @throws LogicException If child didn't override this method.
     */
    public static function _getSupportedTypes()
    {
        throw new LogicException(
            sprintf(
                'You must define and return an array of supported types from %s::_getSupportedTypes() with object keys as array keys. See %s::getSupportedTypes() for more details.',
                static::class,
                KnownObjectRegistryInterface::class
            )
        );
    }

    /**
     * @inheritDoc
     *
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public static function getSupportedTypes()
    {
        if (!self::$types) {
            $types = static::_getSupportedTypes();

            if (empty($types) || !is_array($types)) {
                throw new LogicException(
                    sprintf(
                        'You must define and return array of supported types from %s::_getSupportedTypes() with object keys as array keys. See %s::getSupportedTypes() for more details.',
                        static::class,
                        KnownObjectRegistryInterface::class
                    )
                );
            }

            foreach ($types as $key => $type) {
                self::$types[Validator::getValidatedValue($key, 'string')] = Validator::getValidatedValue(
                    $type, ['class', 'interface']
                );
            }
        }

        return self::$types;
    }

    /**
     * @inheritDoc
     */
    public function register($objectKey, $object)
    {
        Validator::validateType($objectKey, 'string');
        Validator::validateType($object, 'object');

        if (!self::isSupported($object, $objectKey)) {
            if (self::isSupportedKey($objectKey)) {
                throw new ObjectNotSupportedException(
                    sprintf(
                        'ObjectRegistry expects child class or implementation of "%s" for key \'%s\'. Received "%s"',
                        self::getExpectedType($objectKey),
                        $objectKey,
                        get_class($object)
                    )
                );
            } else {
                throw new ObjectKeyNotSupportedException(
                    sprintf(
                        'ObjectRegistry received unsupported key \'%s\'.',
                        $objectKey
                    )
                );
            }
        }

        $this->coll->set($objectKey, $object);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get($objectKey)
    {
        if (!static::isSupportedKey($objectKey)) {
            throw new ObjectKeyNotSupportedException(sprintf('Unknown object key "%s"', $objectKey));
        }

        return parent::get($objectKey);
    }

    /**
     * {@inheritDoc}
     */
    public static function isSupported($class, $objectKey = null)
    {
        $class = is_object(Validator::getValidatedValue($class, ['object', 'class']))
            ? get_class($class)
            : $class;
        $objectKey = Validator::getValidatedValue($objectKey, ['string']);

        if ($objectKey) {
            return is_subclass_of($class, self::getExpectedType($objectKey));
        }

        foreach (self::getSupportedTypes() as $key => $type) {
            if (is_subclass_of($class, $type)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public static function isSupportedKey($objectKey)
    {
        return isset(self::getSupportedTypes()[Validator::getValidatedValue($objectKey, 'string')]);
    }

    /**
     * {@inheritDoc}
     */
    public static function getExpectedType($objectKey)
    {
        if (!self::isSupportedKey($objectKey)) {
            throw new ObjectKeyNotSupportedException(
                sprintf(
                    'Unsupported object key "%s"',
                    $objectKey
                )
            );
        }

        return self::getSupportedTypes()[$objectKey];
    }
}
