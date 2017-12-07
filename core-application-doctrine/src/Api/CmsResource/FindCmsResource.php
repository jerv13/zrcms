<?php

namespace Zrcms\CoreApplicationDoctrine\Api\CmsResource;

use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplicationDoctrine\Api\ApiAbstractCmsResource;
use Zrcms\CoreApplicationDoctrine\Api\BuildBasicCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResource
    extends ApiAbstractCmsResource
    implements \Zrcms\Core\Api\CmsResource\FindCmsResource
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
            $this->contentVersionSyncToProperties
        );
    }
}
