<?php

namespace Zrcms\CoreConfigDataSource\Block\Api;

use Zrcms\Core\Block\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SearchBlockList
{
    /**
     * search
     *
     * @param array $criteria
     *
     * @return array
     */
    public function __invoke(array $blocks, array $criteria = [])
    {
        $result = [];

        foreach ($blocks as $block) {
            if ($this->filter($block, $criteria)) {
                $result[] = $block;
            }
        }

        return $result;
    }

    /**
     * filter
     *
     * @param Block $block
     * @param array $criteria
     *
     * @return bool
     */
    protected function filter(Block $block, array $criteria = [])
    {
        $count = count($criteria);
        $default = new \stdClass();
        $countResult = 0;
        foreach ($criteria as $key => $value) {
            // @todo the is strange
            $method = 'get' . ucfirst($key);
            if (method_exists($block, $method)) {
                // Try to get property if has method
                $blockValue = $block->$method();
            } else {
                // Try to get property from properties
                $blockValue = $block->getProperty($key, $default);
            }

            if ($blockValue === $value) {
                $countResult++;
            }
        }

        return ($countResult === $count);
    }
}
