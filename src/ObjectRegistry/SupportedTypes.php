<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\ObjectRegistry;

use Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotSupportedException;
use Pancoast\Common\ObjectRegistry\Exception\ObjectNotSupportedException;
use Pancoast\Common\Util\Validator;

/**
 * Supported types that a known object registry supports
 *
 * @see \Pancoast\Common\ObjectRegistry\KnownObjectRegistryInterface
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class SupportedTypes implements SupportedTypesInterface
{
    /**
     * Types matching an object key
     *
     * @var array
     */
    private $types = [];

    /**
     * Default types that are supported by any key
     *
     * @var array
     */
    private $defaultTypes = [];

    /**
     * @var Validator
     */
    private $validator;

    /**
     * Constructor
     *
     * Types is an array of types where array key is object key and array value is the class|interface type to be
     * supported. Additionally, you can pass an array key called SupportedTypesInterface::DEFAULT_KEY that itself contains an array of supported
     * classes|interfaces.
     *
     * E.g.,
     * [
     *      'foo_interface' => Foo\BarInterface::class,
     *      'bar_class' => Bizz\Bar::class,
     *      'defaults' => [
     *          Bizz\BuzzInterface::class,
     *      ]
     * ]
     *
     * @param array $types
     * @param Validator $validator
     */
    public function __construct(array $types = [], Validator $validator = null)
    {
        foreach ($types as $objectKey => $type) {
            if ($objectKey == SupportedTypesInterface::KEY_DEFAULTS) {
                foreach ($types[$objectKey] as $type) {
                    $this->addDefault($type);
                }
            }

            $this->add($type, $objectKey);
        }

        $this->validator = $validator ?: new Validator();
    }

    /**
     * @inheritDoc
     */
    public function add($class, $objectKey)
    {
        $class = is_object($this->validator->getValidatedValue($class, ['object', 'class', 'interface']))
            ? get_class($class)
            : $class;
        $objectKey = $this->validator->getValidatedValue($objectKey, ['string', 'null']);

        $this->types[$objectKey] = $class;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addDefault($class)
    {
        $this->defaultTypes[] = $this->validator->getValidatedValue($class, ['class', 'interface']);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addDefaults(array $classes)
    {
        foreach ($classes as $class) {
            // since it validates
            $this->addDefault($class);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDefaults()
    {
        return $this->defaultTypes;
    }

    /**
     * @inheritDoc
     */
    public function get($objectKey = null)
    {
        if ($objectKey == SupportedTypesInterface::KEY_DEFAULTS) {
            return $this->defaultTypes;
        } elseif ($objectKey !== null) {
            if (isset($this->types[$objectKey])) {
                return [$this->types[$objectKey]];
            } elseif (!empty($this->defaultTypes)) {
                return $this->defaultTypes;
            } else {
                return [];
            }
        } else {
            return $this->getAll();
        }
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return array_merge(array_values($this->types), array_values($this->defaultTypes));
    }

    /**
     * @inheritDoc
     */
    public function isSupported($object, $objectKey = null)
    {
        $object = $this->validator->getValidatedValue($object, ['object', 'class', 'interface']);
        $objectKey = $this->validator->getValidatedValue($objectKey, ['string', 'null']);

        // object matches defaults regardless of key
        foreach ($this->defaultTypes as $type) {
            if (is_a($object, $type)) {
                return true;
            }
        }

        if ($objectKey) {
            return isset($this->types[$objectKey]) && is_a($object, $this->types[$objectKey]);
        } else {
            foreach ($this->types as $key => $type) {
                if (is_a($object, $type)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function isSupportedKey($objectKey)
    {
        if ($objectKey == SupportedTypesInterface::KEY_DEFAULTS) {
            return !empty($this->defaultTypes);
        }

        return isset($this->types[$objectKey]) || !empty($this->defaultTypes);
    }

    /**
     * @inheritDoc
     */
    public function validate($object, $objectKey)
    {
        if (!$this->isSupported($object, $objectKey)) {
            if ($this->isSupportedKey($objectKey)) {
                throw new ObjectNotSupportedException(sprintf(
                    'The object registering to key "%s" must be a child or implementation of a supported types. Received "%s". Supported types are ["%s"].',
                    $objectKey,
                    get_class($object),
                    implode('", "', $this->getAll())
                ));
            } elseif (empty($this->types) && empty($this->defaultTypes)) {
                throw new ObjectKeyNotSupportedException(sprintf(
                    'Key must be supported and the object registering to key "%s" must be a child or implementation of a supported type. Received "%s". NO SUPPORTED TYPES SET.',
                    $objectKey,
                    get_class($object)
                ));
            } else {
                throw new ObjectKeyNotSupportedException(sprintf(
                    'Key must be supported and the object registering to key "%s" must be a child or implementation of a supported types. Received "%s". Supported types are ["%s"].',
                    $objectKey,
                    get_class($object),
                    implode('", "', $this->getAll())
                ));
            }
        }
    }
}
