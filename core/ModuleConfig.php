<?php

namespace Zrcms\Core;

use Zrcms\Core\Block\Api\Repository\FindBlock;
use Zrcms\Core\Block\Api\Repository\FindBlocksBy;
use Zrcms\Core\Block\Api\Render\RenderBlock;
use Zrcms\Core\BlockInstance\Api\GetMergedConfig;
use Zrcms\Core\BlockInstance\Api\GetMergedConfigBasic;
use Zrcms\Core\BlockInstance\Api\Render\RenderBlockInstance;
use Zrcms\Cache\Service\Cache;
use Zrcms\Cache\Service\CacheArray;
use Zrcms\Core\Container\Api\BuildContainerUri;
use Zrcms\Core\Container\Api\BuildContainerUriBasic;

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
                    /** BlockInstance **/
                    GetMergedConfig::class => [
                        'class' => GetMergedConfigBasic::class,
                        'arguments' => [
                        ],
                    ],
                    RenderBlockInstance::class => [
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
                    BuildContainerUri::class => [
                        'class' => BuildContainerUriBasic::class,
                        'arguments' => [
                        ],
                    ],
                    RenderContainer::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    /** Layout **/
                ],
            ],
            'zrcms' => [
            ],
        ];
    }
}
