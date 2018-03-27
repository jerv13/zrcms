<?php

namespace Zrcms\CoreSiteContainer\Api\CmsResourceHistory;

use Zrcms\Core\Api\CmsResourceHistory\FindCmsResourceHistoryBy;
use Zrcms\CoreSiteContainer\Model\SiteContainerCmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteContainerCmsResourceHistoryBy extends FindCmsResourceHistoryBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return SiteContainerCmsResourceHistory[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
