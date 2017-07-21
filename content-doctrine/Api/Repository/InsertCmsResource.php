<?php

namespace Zrcms\ContentDoctrine\Api\Repository;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentDoctrine\Api\ApiAbstractCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertCmsResource
    extends ApiAbstractCmsResource
    implements \Zrcms\Content\Api\Repository\InsertCmsResource
{
    /**
     * @param CmsResource $cmsResource
     * @param array       $options
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource,
        array $options = []
    ): CmsResource
    {
        $cmsResource->assertIsNew();

        $this->entityManager->persist($cmsResource);
        $this->entityManager->flush($cmsResource);

        return $cmsResource;
    }
}
