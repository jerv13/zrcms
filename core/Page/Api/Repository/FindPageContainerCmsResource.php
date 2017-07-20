<?php

namespace Zrcms\Core\Page\Api\Repository;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\Container\Api\Repository\FindContainerCmsResource;
use Zrcms\Core\Page\Model\PageContainerCmsResource;

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
