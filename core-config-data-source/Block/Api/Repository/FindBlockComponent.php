<?php

namespace Zrcms\CoreConfigDataSource\Block\Api;

use Zrcms\Core\Block\Model\Block;
use Zrcms\CoreConfigDataSource\Block\Model\BlockConfigFields;
use Zrcms\CoreConfigDataSource\SearchConfigList;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlockComponent implements \Zrcms\Core\Block\Api\Repository\FindBlockComponent
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
     * @param string $name
     * @param array  $options
     *
     * @return Block|null
     */
    public function __invoke(
        string $name,
        array $options = []
    ) {
        $result = $this->searchConfigList->__invoke(
            [BlockConfigFields::NAME => $name]
        );

        if (count($result) > 0) {
            return $result[0];
        }

        return null;
    }
}
