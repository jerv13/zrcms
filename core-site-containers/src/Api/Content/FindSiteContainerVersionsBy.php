<?php

namespace Zrcms\CoreSiteContainer\Api\Content;

use Zrcms\Core\Api\Content\FindContentVersionsBy;
use Zrcms\CoreSiteContainer\Model\SiteContainerVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteContainerVersionsBy extends FindContentVersionsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return SiteContainerVersion[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
