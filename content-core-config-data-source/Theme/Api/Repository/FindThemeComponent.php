<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api\Repository;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\Theme\Model\ThemeComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Api\GetConfigComponents;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Repository\FindComponentAbstract;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindThemeComponent
    extends FindComponentAbstract
    implements \Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent
{
    /**
     * @param GetConfigComponents $getConfigComponents
     * @param SearchConfigList    $searchConfigList
     */
    public function __construct(
        GetConfigComponents $getConfigComponents,
        SearchConfigList $searchConfigList
    ) {
        parent::__construct(
            $getConfigComponents,
            $searchConfigList
        );
    }

    /**
     * @param string $name
     * @param array  $options
     *
     * @return ThemeComponent|Component|null
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
