<?php

namespace Zrcms\CoreContainer\Api\CmsResourceHistory;

use Zrcms\Core\Api\CmsResourceHistory\FindCmsResourceHistoryBy;
use Zrcms\CoreContainer\Model\ContainerCmsResourceHistory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindContainerCmsResourceHistoryBy extends FindCmsResourceHistoryBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return ContainerCmsResourceHistory[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
