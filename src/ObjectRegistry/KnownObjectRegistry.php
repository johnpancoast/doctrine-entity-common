<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 */

namespace Pancoast\Common\ObjectRegistry;

use Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotSupportedException;
use Pancoast\Common\ObjectRegistry\Exception\SupportedTypesNotSetException;

/**
 * A simple registry that can hold any number of known types of object by key.
 *
 * See the docs in KnownObjectRegistryInterface::getSupportedTypes() for details on how to find or define the
 * objects that a registry supports.
 *
 * @see    KnownObjectRegistryInterface::getSupportedTypes()
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class KnownObjectRegistry extends ObjectRegistry implements KnownObjectRegistryInterface
{
    const KEY_DEFAULT = 'default';

    /**
     * Default object
     *
     * If set, clients can register this default object to keys without passing anything to $this->register()
     *
     * @var array
     */
    private $defaultObject;

    /**
     * Supported types
     *
     * Clients use self::getSupportedTypes() to get the types.
     *
     * @var SupportedTypesInterface
     * @see      KnownObjectRegistryInterface::getSupportedTypes()
     */
    private $supportedTypes;

    /**
     * Constructor
     *
     * @param array                        $registryValues
     * @param null|object                  $defaultObject
     * @param SupportedTypesInterface|null $supportedTypes
     *
     * @throws SupportedTypesNotSetException
     */
    public function __construct(
        array $registryValues = [],
        $defaultObject = null,
        SupportedTypesInterface $supportedTypes = null
    ) {
        // call on parent since we need things it constructs but don't pass registry values.
        // we'll do it manually below after we know the default has been set.
        parent::__construct();

        $this->supportedTypes = $supportedTypes ?: new SupportedTypes([]);

        // let children define supported types
        $this->defineSupportedTypes($this->supportedTypes);

        if ($defaultObject) {
            $this->setDefaultObject($defaultObject);
        }

        if (!empty($registryValues)) {
            $this->registerArray($registryValues);
        }
    }

    /**
     * Override this and use $types to add supported types
     *
     * @param SupportedTypesInterface $types
     *
     * @see KnownObjectRegistryInterface::getSupportedTypes()
     * @see KnownObjectRegistry::buildSupportedTypes()
     */
    protected function defineSupportedTypes(SupportedTypesInterface $types)
    {
    }

    /**
     * @inheritDoc
     */
    public function register($objectKey, $object = null)
    {
        $this->validator->validateType($objectKey, 'string');
        $this->validator->validateType($object, ['object', 'null']);

        if (is_null($object)) {
            $object = $this->getDefaultObject();

            if (!$object) {
                throw new NoDefaultObjectException(
                    sprintf(
                        'Attempted to register a default object but no default has been set. Either register an object or set a default with %s::%s',
                        static::class,
                        'setDefaultObject()'
                    )
                );
            }
        }

        $this->supportedTypes->validate($object, $objectKey);

        return parent::register($objectKey, $object);
    }

    /**
     * @inheritDoc
     */
    public function get($objectKey)
    {
        if (!$this->isSupportedKey($objectKey)) {
            throw new ObjectKeyNotSupportedException(sprintf('Unsupported object key "%s"', $objectKey));
        }

        // should we validate lazy loaded object. this should only be run once for a lazy loaded object
        // and must be called before parent::get() since isLoaded() will return differently after that.
        $checkLazy = $this->isLazyLoadable($objectKey) && !$this->isLoaded($objectKey);

        $object = parent::get($objectKey);

        if ($checkLazy) {
            $this->supportedTypes->validate($object, $objectKey);
        }

        return $object;
    }

    /**
     * @inheritDoc
     */
    public function getDefaultObject()
    {
        return $this->defaultObject;
    }

    /**
     * @inheritDoc
     */
    public function setDefaultObject($object)
    {
        $this->defaultObject = $this->validator->getValidatedValue($object, 'object');

        // additionally add the type of this object to supported types
        $this->supportedTypes->addDefault(get_class($object));

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isSupported($object, $objectKey = null)
    {
        return $this->supportedTypes->isSupported($object, $objectKey);
    }

    /**
     * @inheritDoc
     */
    public function isSupportedKey($objectKey)
    {
        return $this->supportedTypes->isSupportedKey($objectKey);
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportedTypes($objectKey = null)
    {
        return $this->supportedTypes->get($objectKey);
    }

    /**
     * @inheritDoc
     */
    public function getAllSupportedTypes()
    {
        return $this->supportedTypes->getAll();
    }
}
