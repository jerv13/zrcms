<?php

namespace Zrcms\CoreApplicationDoctrine\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\FindCmsResourcesPublished as CoreFind;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\ApiAbstractCmsResource;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResources;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResourcesPublished extends ApiAbstractCmsResource implements CoreFind
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return CmsResource[]
     * @throws \Exception
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

        $criteria['published'] = true;

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
