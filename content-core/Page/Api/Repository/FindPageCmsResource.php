<?php

namespace Zrcms\ContentCore\Page\Api\Repository;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageCmsResource extends FindContainerCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return PageCmsResource|CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
