<?php

namespace Zrcms\Content\Api\Component;

use Zrcms\Content\Model\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class FindComponentsByAbstract implements \Zrcms\Content\Api\Component\FindComponentsBy
{
    /**
     * @var GetRegisterComponents
     */
    protected $getRegisterComponents;

    /**
     * @var SearchComponentListBasic
     */
    protected $searchConfigList;

    /**
     * @param GetRegisterComponents    $getRegisterComponents
     * @param SearchComponentListBasic $searchConfigList
     */
    public function __construct(
        GetRegisterComponents $getRegisterComponents,
        SearchComponentListBasic $searchConfigList
    ) {
        $this->getRegisterComponents = $getRegisterComponents;
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
    ): array {
        // @todo implement these
        if ($orderBy !== null || $limit !== null || $offset !== null) {
            throw new \Exception('orderBy, limit and offset not yet implemented');
        }

        $components = $this->getRegisterComponents->__invoke();

        if (empty($criteria)) {
            return $components;
        }

        return $this->searchConfigList->__invoke($components, $criteria);
    }
}
