<?php

namespace Zrcms\Core\Site\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersionsBy;

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
     * @return array [SiteVersion]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
