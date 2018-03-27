<?php

namespace Zrcms\CoreSiteContainer\Api\CmsResourceHistory;

use Zrcms\CoreSiteContainer\Model\SiteContainerCmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLastSiteContainerCmsResourceHistory
{
    /**
     * @param string $cmsResourceId
     *
     * @return SiteContainerCmsResourceHistory|null
     */
    public function __invoke(
        string $cmsResourceId
    );
}
