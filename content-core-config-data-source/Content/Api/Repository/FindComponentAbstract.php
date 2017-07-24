<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Api\Repository;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCoreConfigDataSource\Content\Api\GetConfigComponents;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class FindComponentAbstract implements \Zrcms\Content\Api\Repository\FindComponent
{
    /**
     * @var GetConfigComponents
     */
    protected $getConfigComponents;

    /**
     * @var SearchConfigList
     */
    protected $searchConfigList;

    /**
     * @param GetConfigComponents $getConfigComponents
     * @param SearchConfigList    $searchConfigList
     */
    public function __construct(
        GetConfigComponents $getConfigComponents,
        SearchConfigList $searchConfigList
    ) {
        $this->getConfigComponents = $getConfigComponents;
        $this->searchConfigList = $searchConfigList;
    }

    /**
     * @param string $name
     * @param array  $options
     *
     * @return Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    ) {
        $components = $this->getConfigComponents->__invoke();

        $result = $this->searchConfigList->__invoke(
            $components,
            [ComponentConfigFields::NAME => $name]
        );

        if (count($result) > 0) {
            return $result[0];
        }

        return null;
    }
}
