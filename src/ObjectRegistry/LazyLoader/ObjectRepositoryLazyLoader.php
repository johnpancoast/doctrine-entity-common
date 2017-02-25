<?php
/**
 * @package       johnpancoast/php-common
 * @copyright (c) 2017 John Pancoast <johnpancoaster@gmail.com>
 * @license       MIT
 */

namespace Pancoast\Common\ObjectRegistry\LazyLoader;

use Doctrine\Common\Persistence\ObjectManager;
use Pancoast\Common\ObjectRegistry\LazyLoadableObjectInterface;
use Pancoast\Common\ObjectRegistry\LazyLoader\Exception\RepositoryNotFoundException;
use Pancoast\Common\Util\Validator;

/**
 * An object repository implementation of our lazy loadable interface
 *
 * This can used for doctrine repositories
 *
 * @author John Pancoast <johnpancoaster@gmail.com>
 */
class ObjectRepositoryLazyLoader implements LazyLoadableObjectInterface
{
    /**
     * @var ObjectManager
     */
    protected $om;

    /**
     * Constructor
     *
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->om = $objectManager;
    }

    /**
     * @inheritDoc
     */
    public function loadObject($objectKey)
    {
        $objectKey = Validator::getValidatedValue($objectKey, 'class');

        // doctrine repository lazy loader assumes that object keys are entities
        if (!$repo = $this->om->getRepository($objectKey)) {
            throw new RepositoryNotFoundException(sprintf(
                'Attempted to load a repository for non-existent entity "%s". Note that %s expects object keys to be entity classes.',
                $objectKey,
                static::class
            ));
        }

        return $repo;
    }
}
