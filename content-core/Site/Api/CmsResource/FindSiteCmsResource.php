<?php

namespace Zrcms\ContentCore\Site\Api\CmsResource ;

use Zrcms\Content\Api\CmsResource\FindCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteCmsResource extends FindCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return SiteCmsResource|CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
