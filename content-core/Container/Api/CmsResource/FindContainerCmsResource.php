<?php

namespace Zrcms\ContentCore\Container\Api\CmsResource;

use Zrcms\Content\Api\CmsResource\FindCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerCmsResource extends FindCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return ContainerCmsResource|CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
