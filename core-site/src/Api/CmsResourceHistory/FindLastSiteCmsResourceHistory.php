<?php

namespace Zrcms\CoreSite\Api\CmsResourceHistory;

use Zrcms\CoreSite\Model\SiteCmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLastSiteCmsResourceHistory
{
    /**
     * @param string $cmsResourceId
     *
     * @return SiteCmsResourceHistory|null
     */
    public function __invoke(
        string $cmsResourceId
    );
}
