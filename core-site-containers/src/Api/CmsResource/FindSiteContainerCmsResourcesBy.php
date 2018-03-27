<?php

namespace Zrcms\CoreSiteContainer\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\CoreSiteContainer\Model\SiteContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteContainerCmsResourcesBy extends FindCmsResourcesBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return SiteContainerCmsResource[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
