<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Zrcms\ContentCoreConfigDataSource\SearchConfigList;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlockComponentsBy implements \Zrcms\ContentCore\Block\Api\Repository\FindBlockComponentsBy
{
    /**
     * @var GetBlocks
     */
    protected $getBlocks;

    /**
     * @var SearchConfigList
     */
    protected $searchConfigList;

    /**
     * @param GetBlocks       $getBlocks
     * @param SearchConfigList $searchConfigList
     */
    public function __construct(
        GetBlocks $getBlocks,
        SearchConfigList $searchConfigList
    ) {
        $this->getBlocks = $getBlocks;
        $this->searchConfigList = $searchConfigList;
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        // @todo implement these
        if ($orderBy !== null || $limit !== null || $offset !== null) {
            throw new \Exception('orderBy, limit and offset not yet implemented');
        }

        $blocks = $this->getBlocks->__invoke();

        if (empty($criteria)) {
            return $blocks;
        }

        return $this->searchConfigList->__invoke($blocks, $criteria);
    }
}
