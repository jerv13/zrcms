<?php

namespace Zrcms\CorePage\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\FindCmsResourcesPublished;
use Zrcms\CorePage\Model\PageTemplateCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageTemplateCmsResourcesPublished extends FindCmsResourcesPublished
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
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
