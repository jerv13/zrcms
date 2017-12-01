<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api\Component;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\Block\Model\BlockComponent;
use Zrcms\Content\Api\Component\GetRegisterComponents;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Component\FindComponentAbstract;
use Zrcms\Content\Api\Component\SearchComponentListBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBlockComponent
    extends FindComponentAbstract
    implements \Zrcms\ContentCore\Block\Api\Component\FindBlockComponent
{
    /**
     * @param GetRegisterComponents    $getRegisterComponents
     * @param SearchComponentListBasic $searchConfigList
     */
    public function __construct(
        GetRegisterComponents $getRegisterComponents,
        SearchComponentListBasic $searchConfigList
    ) {
        parent::__construct(
            $getRegisterComponents,
            $searchConfigList
        );
    }

    /**
     * @param string $name
     * @param array  $options
     *
     * @return BlockComponent|Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    ) {
        $blockComponent = parent::__invoke(
            $name,
            $options
        );

        return $blockComponent;
    }
}
