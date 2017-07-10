<?php

namespace Zrcms\Core;

use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\Core\Block\Api\FindBlocksBy;
use Zrcms\Core\Block\Api\RenderBlock;
use Zrcms\Core\BlockInstance\Api\GetMergedConfig;
use Zrcms\Core\BlockInstance\Api\GetMergedConfigBasic;
use Zrcms\Core\BlockInstance\Api\RenderBlockInstance;
use Zrcms\Core\Container\Api\BuildContainerUri;
use Zrcms\Core\Container\Api\BuildContainerUriBasic;
use Zrcms\Core\Container\Api\CreateContainerPublished;
use Zrcms\Core\Container\Api\RenderContainer;
use Zrcms\Core\Layout\Api\FindContainerPathsByHtml;
use Zrcms\Core\Layout\Api\FindContainerPathsByHtmlMustache;

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
                    RenderContainer::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                        ],
                    ],
                    /** Layout **/
                    FindContainerPathsByHtml::class => [
                        'class' => FindContainerPathsByHtmlMustache::class,
                        'arguments' => [
                        ],
                    ],
                ]
            ]
        ];
    }
}
