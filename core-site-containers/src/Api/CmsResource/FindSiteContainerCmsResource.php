<?php

namespace Zrcms\CoreSiteContainer\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\FindCmsResource;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreSiteContainer\Model\SiteContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteContainerCmsResource extends FindCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return SiteContainerCmsResource|CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
