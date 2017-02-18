<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 */

namespace Pancoast\Common\ObjectRegistry;

use Pancoast\Common\Exception\InvalidArgumentException;
use Pancoast\Common\Exception\LogicException;
use Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotSupportedException;
use Pancoast\Common\ObjectRegistry\Exception\ObjectNotSupportedException;
use Pancoast\Common\ObjectRegistry\Exception\SupportedTypesNotSetException;
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
    const KEY_DEFAULT = 'default';

    /**
     * Default object references
     *
     * Maintains all default objects that have been set throughout objects life so that the client
     * receives the default object that was available at the time they registered, not a default that was set later.
     *
     * Also has a key of "default-[object-hash]".
     *
     * @var array
     */
    private $defaultObjects = [];

    /**
     * The current default object key
     *
     * A reference to one of the defaults in self::$defaultObjects
     *
     * @var string|null
     */
    private $currentDefaultKey;

    /**
     * Supported types
     *
     * Use static::getSupportedTypes() to get the types.
     *
     * @see static::getSupportedTypes()
     * @internal This is static because known object registries have static methods to return what they support.
     * @var SupportedTypesInterface
     */
    private static $supportedTypes;

    /**
     * Constructor
     *
     * @param array                        $registryValues
     * @param object|null                  $defaultObject
     *
     * @param SupportedTypesInterface|null $supportedTypes
     */
    public function __construct(
        array $registryValues = [],
        $defaultObject = null,
        SupportedTypesInterface $supportedTypes = null
    )
    {
        self::buildSupportedTypes($supportedTypes);

        // make sure this default is set before parent::__construct() is called so the default
        // is available when setting registry values.
        if ($defaultObject) {
            $this->setDefaultObject($defaultObject);
        }

        parent::__construct($registryValues);
    }

    /**
     * Override this and use $types to add supported types
     *
     * @see KnownObjectRegistryInterface::getSupportedTypes()
     * @throws SupportedTypesNotSetException If child didn't override this method.
     */
    protected static function defineSupportedTypes(SupportedTypesInterface $types)
    {
    }

    /**
     * @inheritDoc
     *
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public static function getSupportedTypes()
    {
        self::buildSupportedTypes();

        return self::$supportedTypes->getAll();
    }

    /**
     * @inheritDoc
     */
    public function register($objectKey, $object = null)
    {
        self::$validator->validateType($objectKey, 'string');
        self::$validator->validateType($object, ['object', 'null']);

        if (is_null($object)) {
            $object = $this->getDefaultObject();

            if (!$object) {
                throw new NoDefaultObjectException(sprintf(
                    'Attempted to register a default object but no default has been set. Either pass an object to $object or set a default with %s::setDefaultObject().',
                    static::class
                ));
            }
        }

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
        if (!static::isSupportedKey($objectKey) && !static::isSupportedKey(SupportedTypes::KEY_DEFAULTS)) {
            throw new ObjectKeyNotSupportedException(sprintf('Unsupported object key "%s"', $objectKey));
        }

        return parent::get($objectKey);
    }

    /**
     * @inheritDoc
     */
    public function getDefaultObject($defaultKey = null)
    {
        if ($defaultKey) {
            if (!isset($this->defaultObjects[$defaultKey])) {
                throw new DefaultKeyNotSupportedException(sprintf(
                    'Default key "%s" not supported',
                    $defaultKey
                ));
            }

            return $this->defaultObjects[$defaultKey];
        } elseif ($this->currentDefaultKey && isset($this->defaultObjects[$this->currentDefaultKey])) {
            return $this->defaultObjects[$this->currentDefaultKey];
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function setDefaultObject($object)
    {
        $object = self::$validator->getValidatedValue($object, 'object');

        $key = sprintf('%s-%s', self::KEY_DEFAULT, spl_object_hash($object));

        $this->defaultObjects[$key] = $object;
        $this->currentDefaultKey = $key;

        // additionally add the type of this object to supported types
        self::$supportedTypes->addDefault(get_class($object));

        return $key;
    }

    /**
     * {@inheritDoc}
     */
    public static function isSupported($object, $objectKey = null)
    {
        self::buildSupportedTypes();

        return self::$supportedTypes->isSupported($object, $objectKey);
    }

    /**
     * @inheritDoc
     */
    public static function isSupportedKey($objectKey)
    {
        self::buildSupportedTypes();

        return self::$supportedTypes->isSupportedKey($objectKey);
    }

    /**
     * {@inheritDoc}
     */
    public static function getExpectedType($objectKey)
    {
        self::buildSupportedTypes();

        if (!self::isSupportedKey($objectKey)) {
            throw new ObjectKeyNotSupportedException(
                sprintf(
                    'Unsupported object key "%s"',
                    $objectKey
                )
            );
        }

        return self::$supportedTypes->get($objectKey);
    }

    /**
     * @internal Allow supported types be passed or built then handed to children to define more restrictions.
     */
    private static function buildSupportedTypes(SupportedTypesInterface $supportedTypes = null)
    {
        if (!self::$supportedTypes) {
            self::$supportedTypes = $supportedTypes ?: new SupportedTypes();
            static::defineSupportedTypes(self::$supportedTypes);
        }
    }
}
