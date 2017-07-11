<?php

namespace Zrcms\CoreConfigDataSource\Block\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlocksBy implements \Zrcms\Core\Block\Api\FindBlocksBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     * @param array      $options
     *
     * @return array
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array {

    }
}
