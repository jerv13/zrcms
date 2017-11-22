<?php

namespace Zrcms\ContentCore\Page\Api\CmsResource;

use Zrcms\Content\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\ContentCore\Page\Model\PageCmsResource;

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
     * @return PageCmsResource[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
