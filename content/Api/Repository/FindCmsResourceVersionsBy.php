<?php

namespace Zrcms\Content\Api\Repository;

use Zrcms\Content\Model\CmsResourceVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindCmsResourceVersionsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return CmsResourceVersion[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}
