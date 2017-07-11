<?php

namespace Zrcms\CoreConfigDataSource\Block\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlocksBy implements \Zrcms\Core\Block\Api\FindBlocksBy
{
    /**
     * @var GetBlocks
     */
    protected $getBlocks;

    /**
     * @var SearchBlockList
     */
    protected $searchBlockList;

    /**
     * @param GetBlocks       $getBlocks
     * @param SearchBlockList $searchBlockList
     */
    public function __construct(
        GetBlocks $getBlocks,
        SearchBlockList $searchBlockList
    ) {
        $this->getBlocks = $getBlocks;
        $this->searchBlockList = $searchBlockList;
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

        return $this->searchBlockList->__invoke($blocks, $criteria);
    }
}
