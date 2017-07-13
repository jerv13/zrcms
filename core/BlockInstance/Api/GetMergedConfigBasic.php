<?php

namespace Zrcms\Core\BlockInstance\Api;

use Zrcms\Core\Block\Api\Repository\FindBlock;
use Zrcms\Core\Block\Model\Block;
use Zrcms\Core\BlockInstance\Model\BlockInstance;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetMergedConfigBasic implements GetMergedConfig
{
    protected $findBlock;

    /**
     * @param FindBlock $findBlock
     */
    public function __construct(
        FindBlock $findBlock
    ) {
        $this->findBlock = $findBlock;
    }

    /**
     * @param BlockInstance $blockInstance
     * @param array         $options
     *
     * @return array
     */
    public function __invoke(
        BlockInstance $blockInstance,
        array $options = []
    ): array
    {
        /** @var Block $bock */
        $bock = $this->findBlock->__invoke(
            $blockInstance->getBlockName()
        );

        return $this->merge($bock->getDefaultConfig(), $blockInstance->getConfig());
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
