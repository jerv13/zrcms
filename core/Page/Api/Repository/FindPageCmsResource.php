<?php

namespace Zrcms\Core\Page\Api\Repository;

use Zrcms\Content\Api\Repository\FindCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\Page\Model\PageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageCmsResource extends FindCmsResource
{
    /**
     * @param string $uri
     * @param array  $options
     *
     * @return PageCmsResource|CmsResource|null
     */
    public function __invoke(
        string $uri,
        array $options = []
    );
}
