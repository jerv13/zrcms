<?php

namespace Zrcms\Core;

use Zrcms\ContentCore\Block\Api\Repository\FindBlock;
use Zrcms\ContentCore\Block\Api\Repository\FindBlocksBy;
use Zrcms\ContentCore\Block\Api\Render\RenderBlock;
use Zrcms\ContentCore\Block\Api\GetMergedConfig;
use Zrcms\ContentCore\Block\Api\GetMergedConfigBasic;
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
