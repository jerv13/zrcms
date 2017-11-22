<?php

namespace Zrcms\ContentRedirect\Api\CmsResource;

use Zrcms\Content\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindRedirectCmsResourcesBy extends FindCmsResourcesBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return RedirectCmsResource[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
