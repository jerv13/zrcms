<?php

namespace Zrcms\ContentCoreConfigDataSource\Basic\Api\Component;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\Basic\Model\BasicComponent;
use Zrcms\Content\Api\Component\GetRegisterComponents;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Component\FindComponentAbstract;
use Zrcms\Content\Api\Component\SearchComponentListBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBasicComponent
    extends FindComponentAbstract
    implements \Zrcms\ContentCore\Basic\Api\Component\FindBasicComponent
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
