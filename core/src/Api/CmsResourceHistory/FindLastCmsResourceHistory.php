<?php

namespace Zrcms\Core\Api\CmsResourceHistory;

use Zrcms\Core\Model\CmsResourceHistory;

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
