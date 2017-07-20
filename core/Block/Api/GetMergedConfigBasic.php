<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\Core\Block\Api\Repository\FindBlockComponent;
use Zrcms\Core\Block\Model\BlockComponent;
use Zrcms\Core\Block\Model\Block;

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
     * @param array                 $options
     *
     * @return array
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
