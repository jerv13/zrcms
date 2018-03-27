<?php

namespace Zrcms\CoreSiteContainer\Api\CmsResourceHistory;

use Zrcms\Core\Api\CmsResourceHistory\FindCmsResourceHistory;
use Zrcms\CoreSiteContainer\Model\SiteContainerCmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteContainerCmsResourceHistory extends FindCmsResourceHistory
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return SiteContainerCmsResourceHistory|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
