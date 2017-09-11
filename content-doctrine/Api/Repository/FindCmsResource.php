<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentDoctrine\Api\ApiAbstractCmsResource;
use Zrcms\ContentDoctrine\Api\BuildBasicCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResource
    extends ApiAbstractCmsResource
    implements \Zrcms\Content\Api\Repository\FindCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    ) {
        $repository = $this->entityManager->getRepository(
            $this->entityClassCmsResource
        );

        $entity = $repository->find($id);

        return BuildBasicCmsResource::invoke(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $this->entityClassContentVersion,
            $this->classContentVersionBasic,
            $entity,
            $this->cmsResourceSyncToProperties,
            $this->contentVersionSyncToProperties
        );
    }
}
