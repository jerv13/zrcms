<?php

namespace Zrcms\ContentCore\Page\Api\Repository;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResource;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPageContainerCmsResource extends FindContainerCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return PageContainerCmsResource|CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
