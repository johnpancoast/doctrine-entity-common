<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\ObjectRegistry;

use Pancoast\Common\ObjectRegistry\Exception\ObjectKeyNotSupportedException;
use Pancoast\Common\Util\Validator;

/**
 * Supported types for an object registry
 *
 * This is assumed to be used by instances of KnownObjectRegistryInterface
 *
 * @see \Pancoast\Common\ObjectRegistry\KnownObjectRegistryInterface
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class SupportedTypes implements SupportedTypesInterface
{
    const KEY_DEFAULTS = 'defaults';

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
     * Constructor
     *
     * Types is an array of types where array key is object key and array value is the class|interface type to be
     * supported. Additionally, you can pass an array key called self::DEFAULT_KEY that itself contains an array of supported
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
     */
    public function __construct(array $types = [])
    {
        foreach ($types as $objectKey => $type) {
            if ($objectKey == self::KEY_DEFAULTS) {
                foreach ($types[$objectKey] as $type) {
                    $this->addDefault($type);
                }
            }

            $this->add($type, $objectKey);
        }
    }

    /**
     * @inheritDoc
     */
    public function add($class, $objectKey)
    {
        $class = is_object(Validator::getValidatedValue($class, ['object', 'class', 'interface']))
            ? get_class($class)
            : $class;
        $objectKey = Validator::getValidatedValue($objectKey, ['string', 'null']);

        $this->types[$objectKey] = $class;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addDefault($class)
    {
        $this->defaultTypes[] = $class;
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
    public function get($objectKey)
    {
        if ($objectKey == self::KEY_DEFAULTS) {
            return $this->defaultTypes;
        } else {
            if (!$this->isSupportedKey($objectKey)) {
                throw new ObjectKeyNotSupportedException(sprintf(
                    'Object key "%s" not supported',
                    $objectKey
                ));
            }

            return $this->types[$objectKey];
        }
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        $types = $this->types;

        foreach ($this->defaultTypes as $type) {
            $types['defaults'][] = $type;
        }

        return $types;
    }

    /**
     * @inheritDoc
     */
    public function isSupported($object, $objectKey = null)
    {
        $object = Validator::getValidatedValue($object, ['object', 'class', 'interface']);
        $objectKey = Validator::getValidatedValue($objectKey, ['string', 'null']);

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
                if (is_a($object, $this)) {
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
        if ($objectKey == self::KEY_DEFAULTS) {
            return !empty($this->defaultTypes);
        }

        return isset($this->types[$objectKey]);
    }
}
