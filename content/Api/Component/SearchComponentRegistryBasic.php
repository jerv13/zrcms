<?php

namespace Zrcms\Content\Api\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SearchComponentRegistryBasic implements SearchComponentRegistry
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
    ):array {
        $result = [];

        foreach ($componentConfigs as $componentConfig) {
            if ($this->filter($componentConfig, $criteria)) {
                $result[] = $componentConfig;
            }
        }

        return $result;
    }

    /**
     * filter
     *
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
            $componentValue = null;

            if (array_key_exists($key, $componentConfig)) {
                $componentValue = $componentConfig[$key];
            } else {
                continue;
            }

            if ($componentValue === $value) {
                $countResult++;
            }
        }

        return ($countResult === $count);
    }
}
