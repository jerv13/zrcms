<?php

namespace Zrcms\CoreConfigDataSource\Block\Api;

use Zrcms\Core\Block\Model\Block;
use Zrcms\CoreConfigDataSource\Block\Model\BlockConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlock implements \Zrcms\Core\Block\Api\Repository\FindBlock
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
     * @param string $name
     * @param array  $options
     *
     * @return Block|null
     */
    public function __invoke(
        string $name,
        array $options = []
    ) {
        $result = $this->searchBlockList->__invoke(
            [BlockConfigFields::NAME => $name]
        );

        if (count($result) > 0) {
            return $result[0];
        }

        return null;
    }
}
