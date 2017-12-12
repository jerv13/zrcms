<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\SearchComponentConfigs;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SearchComponentConfigsBasic implements SearchComponentConfigs
{
    /**
     * @param array $componentConfigs
     * @param array $criteria
     *
     * @return array
     */
    public function __invoke(
        array $componentConfigs,
        array $criteria = []
    ):array
    {
        $result = [];

        foreach ($componentConfigs as $componentConfig) {
            if ($this->filter($componentConfig, $criteria)) {
                $result[] = $componentConfig;
            }
        }

        return $result;
    }

    /**
     * @param array $componentConfig
     * @param array $criteria
     *
     * @return bool
     */
    protected function filter(
        array $componentConfig,
        array $criteria = []
    ) {
        $count = count($criteria);
        $countResult = 0;
        foreach ($criteria as $key => $value) {
            if (!array_key_exists($key, $componentConfig)) {
                continue;
            }

            $componentValue = $componentConfig[$key];

            if ($componentValue === $value) {
                $countResult++;
            }
        }

        return ($countResult === $count);
    }
}
