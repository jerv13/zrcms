<?php

namespace Zrcms\Content\Api\CmsResourceHistory;

use Zrcms\Content\Model\CmsResourcePublishHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLastCmsResourceHistory
{
    /**
     * @param string $cmsResourceId
     *
     * @return CmsResourcePublishHistory|null
     */
    public function __invoke(
        string $cmsResourceId
    );
}
