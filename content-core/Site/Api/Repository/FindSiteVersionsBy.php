<?php

namespace Zrcms\ContentCore\Site\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersionsBy;
use Zrcms\ContentCore\Site\Model\SiteVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindSiteVersionsBy extends FindContentVersionsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return SiteVersion[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
