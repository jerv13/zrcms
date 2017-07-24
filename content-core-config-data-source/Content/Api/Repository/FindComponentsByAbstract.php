<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Api\Repository;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCoreConfigDataSource\Content\Api\GetConfigComponents;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class FindComponentsByAbstract implements \Zrcms\Content\Api\Repository\FindComponentsBy
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
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return Component[]
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

        $components = $this->getConfigComponents->__invoke();

        if (empty($criteria)) {
            return $components;
        }

        return $this->searchConfigList->__invoke($components, $criteria);
    }
}
