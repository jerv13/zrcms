<?php

namespace Zrcms\Content\Api\CmsResourceHistory;

use Zrcms\Content\Model\CmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindCmsResourceHistoryBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return CmsResourceHistory[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
