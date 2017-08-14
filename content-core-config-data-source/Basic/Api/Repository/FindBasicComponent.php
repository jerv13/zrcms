<?php

namespace Zrcms\ContentCoreConfigDataSource\Basic\Api\Repository;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\Basic\Model\BasicComponent;
use Zrcms\Content\Api\GetRegisterComponents;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Repository\FindComponentAbstract;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBasicComponent
    extends FindComponentAbstract
    implements \Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent
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
     * @return BasicComponent|Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    ) {

        $basicComponent = parent::__invoke(
            $name,
            $options
        );

        return $basicComponent;
    }
}
