<?php

namespace Zrcms\CorePage\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\CorePage\Model\PageTemplateCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageTemplateCmsResourcesBy extends FindCmsResourcesBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     * @param array      $options
     *
     * @return PageTemplateCmsResource[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
