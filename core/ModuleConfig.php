<?php

namespace Zrcms\Core;

use Zrcms\Core\Block\Api\Repository\FindBlock;
use Zrcms\Core\Block\Api\Repository\FindBlocksBy;
use Zrcms\Core\Block\Api\Render\RenderBlock;
use Zrcms\Core\Block\Api\GetMergedConfig;
use Zrcms\Core\Block\Api\GetMergedConfigBasic;
use Zrcms\Cache\Service\Cache;
use Zrcms\Cache\Service\CacheArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    /** Block **/
                    FindBlock::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    FindBlocksBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    RenderBlock::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    /** Block **/
                    GetMergedConfig::class => [
                        'class' => GetMergedConfigBasic::class,
                        'arguments' => [
                        ],
                    ],
                    RenderBlock::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    /** Cache **/
                    Cache::class => [
                        'class' => CacheArray::class,
                        'arguments' => [
                        ],
                    ],
                    /** Container **/

                    /** Layout **/
                ],
            ],
            'zrcms' => [
            ],
        ];
    }
}
