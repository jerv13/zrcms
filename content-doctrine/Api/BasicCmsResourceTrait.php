<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait BasicCmsResourceTrait
{
    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var string
     */
    protected $classCmsResourceBasic;

    /**
     * @param CmsResource|null $entity
     *
     * @return null
     */
    protected function newBasic($entity)
    {
        if(!is_a($entity, $this->entityClass)) {
            return null;
        }

        $classCmsResourceBasic = $this->classCmsResourceBasic;

        return new $classCmsResourceBasic(
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
