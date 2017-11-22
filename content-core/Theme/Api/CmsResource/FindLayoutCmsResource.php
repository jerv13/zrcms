<?php

namespace Zrcms\ContentCore\Theme\Api\CmsResource;

use Zrcms\Content\Api\CmsResource\FindCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLayoutCmsResource extends FindCmsResource
{
    /**
     * @param string $layoutUri
     * @param array  $options
     *
     * @return LayoutCmsResource|CmsResource|null
     */
    public function __invoke(
        string $layoutUri,
        array $options = []
    );
}
