<?php

namespace Zrcms\Core;

use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\Core\Block\Api\FindBlocksBy;
use Zrcms\Core\Block\Api\RenderBlock;
use Zrcms\Core\BlockInstance\Api\GetMergedConfig;
use Zrcms\Core\BlockInstance\Api\GetMergedConfigBasic;
use Zrcms\Core\BlockInstance\Api\RenderBlockInstance;
use Zrcms\Core\Cache\Service\Cache;
use Zrcms\Core\Cache\Service\CacheArray;
use Zrcms\Core\Container\Api\BuildContainerUri;
use Zrcms\Core\Container\Api\BuildContainerUriBasic;
use Zrcms\Core\Container\Api\CreateContainerPublished;
use Zrcms\Core\Container\Api\FindContainerPathsByHtml;
use Zrcms\Core\Container\Api\FindContainerPathsByHtmlMustache;
use Zrcms\Core\Container\Api\RenderContainer;

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
                    CreateContainerPublished::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    RenderContainer::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    FindContainerPathsByHtml::class => [
                        'class' => FindContainerPathsByHtmlMustache::class,
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
