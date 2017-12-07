<?php

namespace Zrcms\CoreApplicationDoctrine\Api;

use Zrcms\CoreApplicationDoctrine\Exception\InvalidEntityException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ApiAbstract
{
    /**
     * @param $entityClass
     * @param $requiredEntityClass
     *
     * @return void
     * @throws InvalidEntityException
     */
    protected function assertValidEntityClass($entityClass, $requiredEntityClass)
    {
        if (!is_a($entityClass, $requiredEntityClass, true)
            && !is_subclass_of($entityClass, $requiredEntityClass, true)
        ) {
            throw new InvalidEntityException(
                'Invalid entityClass (' . $entityClass . ')'
                . ' entityClass must be a: ' . $requiredEntityClass
                . ' for: ' . get_class($this)
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
                'Invalid entity (' . get_class($entity) . ')'
                . ' entity must be of type: ' . $entityClass
                . ' for: ' . get_class($this)
            );
        }
    }
}
