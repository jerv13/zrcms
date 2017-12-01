<?php

namespace Zrcms\ContentCore;

use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentConfig;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentConfigByStrategy;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentConfigBc;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentConfigBcFactory;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentConfigJsonFile;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentRegistry;
use Zrcms\ContentCore\Block\Api\GetBlockConfigFields;
use Zrcms\ContentCore\Block\Api\GetBlockConfigFieldsBcSubstitution;
use Zrcms\ContentCore\Block\Api\GetMergedConfig;
use Zrcms\ContentCore\Block\Api\GetMergedConfigBasic;
use Zrcms\ContentCore\Block\Api\Component\GetRegisterBlockComponents;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfig;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfigBc;
use Zrcms\ContentCore\Block\Api\Render\GetBlockRenderTags;
use Zrcms\ContentCore\Block\Api\Render\GetBlockRenderTagsBasic;
use Zrcms\ContentCore\Block\Api\Render\RenderBlock;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBasic;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBc;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBcFactory;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockMissing;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockMissingComment;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockMustache;
use Zrcms\ContentCore\Block\Api\Component\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Component\FindBlockComponentsBy;
use Zrcms\ContentCore\Block\Api\GetBlockData;
use Zrcms\ContentCore\Block\Api\GetBlockDataBasic;
use Zrcms\ContentCore\Block\Api\GetBlockDataNoop;
use Zrcms\ContentCore\Block\Api\Render\WrapRenderedBlockVersion;
use Zrcms\ContentCore\Block\Api\Render\WrapRenderedBlockVersionLegacy;
use Zrcms\ContentCore\Block\Model\ServiceAliasBlock;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigBlock
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    ReadBlockComponentConfig::class => [
                        'class' => ReadBlockComponentConfigByStrategy::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    ReadBlockComponentConfigBc::class => [
                        'factory' => ReadBlockComponentConfigBcFactory::class
                    ],
                    ReadBlockComponentConfigJsonFile::class => [
                        'class' => ReadBlockComponentConfigJsonFile::class,
                    ],
                    ReadBlockComponentRegistry::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => ReadBlockComponentRegistry::class],
                        ],
                    ],
                    GetBlockRenderTags::class => [
                        'class' => GetBlockRenderTagsBasic::class,
                        'arguments' => [
                            '0-' => GetBlockData::class,
                            '1-' => GetMergedConfig::class,
                        ],
                    ],
                    RenderBlock::class => [
                        'class' => RenderBlockBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                            '1-' => FindBlockComponent::class,
                            '2-' => RenderBlockMissing::class,
                            '3-' => ['literal' => RenderBlockMustache::class],
                        ],
                    ],
                    RenderBlockBc::class => [
                        'factory' => RenderBlockBcFactory::class,
                    ],
                    RenderBlockMissing::class => [
                        'class' => RenderBlockMissingComment::class
                    ],
                    RenderBlockMustache::class => [
                        'arguments' => [
                            '0-' => FindBlockComponent::class,
                        ],
                    ],
                    FindBlockComponent::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindBlockComponent::class],
                        ],
                    ],
                    FindBlockComponentsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindBlockComponentsBy::class],
                        ],
                    ],
                    GetBlockData::class => [
                        'class' => GetBlockDataBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                            '1-' => FindBlockComponent::class
                        ],
                    ],
                    GetBlockDataNoop::class => [],
                    GetBlockConfigFields::class => [
                        'class' => GetBlockConfigFields::class,
                    ],
                    GetBlockConfigFieldsBcSubstitution::class => [
                        'class' => GetBlockConfigFieldsBcSubstitution::class,
                    ],
                    GetMergedConfig::class => [
                        'class' => GetMergedConfigBasic::class,
                        'arguments' => [
                            '0-' => FindBlockComponent::class
                        ],
                    ],
                    GetRegisterBlockComponents::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => GetRegisterBlockComponents::class],
                        ],
                    ],
                    PrepareBlockConfig::class => [
                        'class' => PrepareBlockConfigBc::class,
                        'arguments' => [
                            '0-' => GetBlockConfigFields::class,
                            '1-' => GetBlockConfigFieldsBcSubstitution::class,
                        ],
                    ],
                    PrepareBlockConfigBc::class => [
                        'arguments' => [
                            '0-' => GetBlockConfigFields::class,
                            '1-' => GetBlockConfigFieldsBcSubstitution::class,
                        ],
                    ],
                    WrapRenderedBlockVersion::class => [
                        'class' => WrapRenderedBlockVersionLegacy::class,
                        'arguments' => [
                            '0-' => FindBlockComponent::class
                        ],
                    ],
                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.block.component.config-reader'
                ServiceAliasBlock::NAMESPACE_COMPONENT_CONFIG_READER => [
                    ReadBlockComponentConfigBc::SERVICE_ALIAS
                    => ReadBlockComponentConfigBc::class,

                    ReadBlockComponentConfigJsonFile::SERVICE_ALIAS
                    => ReadBlockComponentConfigJsonFile::class,
                ],
                // 'zrcms.block.content.renderer'
                ServiceAliasBlock::NAMESPACE_CONTENT_RENDERER => [
                    'mustache' // RenderBlockMustache::SERVICE_ALIAS
                    => RenderBlockMustache::class,

                    'bc' // RenderBlockBc::SERVICE_ALIAS
                    => RenderBlockBc::class,
                ],
                // 'zrcms.block.content.data-provider'
                ServiceAliasBlock::NAMESPACE_CONTENT_DATA_PROVIDER => [
                    'noop'
                    => GetBlockDataNoop::class,
                ],
            ],
        ];
    }
}
