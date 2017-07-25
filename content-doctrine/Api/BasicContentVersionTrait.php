<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait BasicContentVersionTrait
{
    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var string
     */
    protected $classContentVersionBasic;

    /**
     * @param ContentVersion|null $entity
     *
     * @return null
     */
    protected function newBasic($entity)
    {
        if(!is_a($entity, $this->entityClass)) {
            return null;
        }

        $classContentVersionBasic = $this->classContentVersionBasic;

        return new $classContentVersionBasic(
            $entity->getProperties(),
            $entity->getCreatedByUserId(),
            $entity->getCreatedReason()
        );
    }

    /**
     * @param array $entities
     *
     * @return array
     */
    protected function newBasics(array $entities)
    {
        $basics = [];

        foreach ($entities as $entity) {
            $basics[] = $this->newBasic($entity);
        }

        return $basics;
    }
}
