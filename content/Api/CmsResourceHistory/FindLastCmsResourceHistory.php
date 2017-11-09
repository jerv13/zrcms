<?php

namespace Zrcms\Content\Api\CmsResourceHistory;

use Zrcms\Content\Model\CmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLastCmsResourceHistory
{
    /**
     * @param string $cmsResourceId
     *
     * @return CmsResourceHistory|null
     */
    public function __invoke(
        string $cmsResourceId
    );
}
