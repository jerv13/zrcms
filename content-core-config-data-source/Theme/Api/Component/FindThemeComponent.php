<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api\Component;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\Theme\Model\ThemeComponent;
use Zrcms\Content\Api\Component\GetRegisterComponents;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Component\FindComponentAbstract;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindThemeComponent
    extends FindComponentAbstract
    implements \Zrcms\ContentCore\Theme\Api\Component\FindThemeComponent
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
