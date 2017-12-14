<?php

namespace Zrcms\CoreBlock\Api;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreBlock\Model\Block;
use Zrcms\CoreBlock\Model\BlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetMergedConfigBasic implements GetMergedConfig
{
    protected $findComponent;

    /**
     * @param FindComponent $findComponent
     */
    public function __construct(
        FindComponent $findComponent
    ) {
        $this->findComponent = $findComponent;
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
    ): array {
        /** @var BlockComponent $bockComponent */
        $bockComponent = $this->findComponent->__invoke(
            'block',
            $block->getBlockComponentName()
        );

        if (empty($bockComponent)) {
            // bockComponent my have been removed, so we return only the config we know
            return $block->getConfig();
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
                        $default[$key] = $this->merge(
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
