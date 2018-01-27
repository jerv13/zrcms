<?php

namespace Zrcms\CoreSite\Api\CmsResourceHistory;

use Zrcms\Core\Api\CmsResourceHistory\FindCmsResourceHistory;
use Zrcms\CoreSite\Model\SiteCmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteCmsResourceHistory extends FindCmsResourceHistory
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return SiteCmsResourceHistory|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
