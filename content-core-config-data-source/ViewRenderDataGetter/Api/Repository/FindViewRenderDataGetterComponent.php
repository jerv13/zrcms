<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\Repository;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\ViewRenderDataGetter\Model\ViewRenderDataGetterComponent;
use Zrcms\Content\Api\GetRegisterComponents;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Repository\FindComponentAbstract;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindViewRenderDataGetterComponent
    extends FindComponentAbstract
    implements \Zrcms\ContentCore\ViewRenderDataGetter\Api\Repository\FindViewRenderDataGetterComponent
{
    /**
     * @param GetRegisterComponents $getRegisterComponents
     * @param SearchConfigList    $searchConfigList
     */
    public function __construct(
        GetRegisterComponents $getRegisterComponents,
        SearchConfigList $searchConfigList
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
     * @return ViewRenderDataGetterComponent|Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    ) {
        return parent::__invoke(
            $name,
            $options
        );
    }
}
