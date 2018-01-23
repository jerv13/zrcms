<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\Component\ReadComponentConfigs;
use Zrcms\Core\Model\Component;

/**
 * @todo Find by properties
 *
 * @author James Jervis - https://github.com/jerv13
 */
class FindComponentsByBasic implements FindComponentsBy
{
    protected $searchConfigConfigs;
    protected $readComponentConfigs;
    protected $buildComponentObject;

    /**
     * @param SearchComponentConfigsBasic $searchConfigConfigs
     * @param ReadComponentConfigs        $readComponentConfigs
     * @param BuildComponentObject        $buildComponentObject
     */
    public function __construct(
        SearchComponentConfigsBasic $searchConfigConfigs,
        ReadComponentConfigs $readComponentConfigs,
        BuildComponentObject $buildComponentObject
    ) {
        $this->searchConfigConfigs = $searchConfigConfigs;
        $this->readComponentConfigs = $readComponentConfigs;
        $this->buildComponentObject = $buildComponentObject;
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

        $componentConfigs = $this->readComponentConfigs->__invoke();

        if (empty($criteria)) {
            return $this->buildComponentObjects(
                $componentConfigs
            );
        }

        $componentConfigsResult = $this->searchConfigConfigs->__invoke(
            $componentConfigs,
            $criteria
        );

        return $this->buildComponentObjects(
            $componentConfigsResult
        );
    }

    /**
     * @param array $componentConfigs
     *
     * @return Component[]
     */
    protected function buildComponentObjects(
        array $componentConfigs
    ) {
        $configs = [];
        foreach ($componentConfigs as $componentConfig) {
            $configs[] = $this->buildComponentObject->__invoke(
                $componentConfig
            );
        }

        return $configs;
    }
}
