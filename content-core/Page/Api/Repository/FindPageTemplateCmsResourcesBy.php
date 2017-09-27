<?php

namespace Zrcms\ContentCore\Page\Api\Repository;

use Zrcms\Content\Api\Repository\FindCmsResourcesBy;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;

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
     * @return PageContainerCmsResource[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
