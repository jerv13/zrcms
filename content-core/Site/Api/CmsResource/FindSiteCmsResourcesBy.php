<?php

namespace Zrcms\ContentCore\Site\Api\CmsResource ;

use Zrcms\Content\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteCmsResourcesBy extends FindCmsResourcesBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return SiteCmsResource[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
