<?php

namespace Zrcms\CoreApplicationDoctrine\Api\CmsResource;

use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\ApiAbstractCmsResource;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResources;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResourcesBy extends ApiAbstractCmsResource implements \Zrcms\Core\Api\CmsResource\FindCmsResourcesBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return CmsResource[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        $entities = $repository->findBy(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );

        return BuildBasicCmsResources::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $entities,
            $this->contentVersionSyncToProperties
        );
    }
}
