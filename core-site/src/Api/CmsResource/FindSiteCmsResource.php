<?php

namespace Zrcms\CoreSite\Api\CmsResource ;

use Zrcms\Core\Api\CmsResource\FindCmsResource;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;

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
