<?php

namespace Zrcms\Core\BlockInstance\Api;

use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\Core\BlockInstance\Model\BlockInstance;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetMergedConfigEntity implements GetMergedConfig
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
        $bock = $this->findBlock->__invoke(
            $blockInstance->getName()
        );
    }

    protected function merge($default, $changes)
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
