<?php

namespace Zrcms\ContentDoctrine\Api;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentDoctrine\Exception\InvalidEntityException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ApiAbstract
{
    /**
     * @param $entity
     * @param $entityClass
     *
     * @return void
     * @throws InvalidEntityException
     */
    protected function assertValidEntityClass($entityClass, $entity)
    {
        if (!is_a($entity, $entityClass)) {
            throw new InvalidEntityException(
                'Invalid entityClass (' . $entityClass . '), entityClass must be: ' . get_class($entity)
            );
        }
    }

    /**
     * @param $entity
     * @param $entityClass
     *
     * @return void
     * @throws InvalidEntityException
     */
    protected function assertValidEntity($entity, $entityClass)
    {
        if (!is_a($entity, $entityClass)) {
            throw new InvalidEntityException(
                'Invalid entity (' . get_class($entity) . '), entity must be of type: ' . $entityClass
            );
        }
    }
}
