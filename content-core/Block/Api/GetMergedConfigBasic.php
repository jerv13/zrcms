<?php

namespace Zrcms\ContentCore\Block\Api;

use Zrcms\ContentCore\Block\Api\Repository\FindBlockComponent;
use Zrcms\ContentCore\Block\Model\Block;
use Zrcms\ContentCore\Block\Model\BlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetMergedConfigBasic implements GetMergedConfig
{
    protected $findBlockComponent;

    /**
     * @param FindBlockComponent $findBlockComponent
     */
    public function __construct(
        FindBlockComponent $findBlockComponent
    ) {
        $this->findBlockComponent = $findBlockComponent;
    }

    /**
     * @param Block $block
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Block $block,
        array $options = []
    ): array
    {
        /** @var BlockComponent $bockComponent */
        $bockComponent = $this->findBlockComponent->__invoke(
            $block->getBlockComponentName()
        );

        if (empty($bockComponent)) {
            throw new \Exception("Block not found: (" . $block->getBlockComponentName() . ")");
        }

        return $this->merge($bockComponent->getDefaultConfig(), $block->getConfig());
    }

    /**
     * @param array $default
     * @param array $changes
     *
     * @return array
     */
    protected function merge(array $default, array $changes)
    {
        if (empty($default)) {
            return $changes;
        }

        if (empty($changes)) {
            return $default;
        }

        foreach ($changes as $key => &$value) {
            if (is_array($value)) {
                if (isset($value['0'])) {
                    /*
                     * Numeric arrays ignore default values because of the
                     * "more in default that on production" issue
                     */
                    $default[$key] = $changes[$key];
                } else {
                    if (isset($default[$key])) {
                        $default[$key] = $this->__invoke(
                            $default[$key],
                            $changes[$key]
                        );
                    } else {
                        $default[$key] = $changes[$key];
                    }
                }
            } else {
                $default[$key] = $changes[$key];
            }
        }

        return $default;
    }
}
