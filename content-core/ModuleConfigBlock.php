<?php

namespace Zrcms\ContentCore;

use Zrcms\Content\Api\Component\BuildComponentObject;
use Zrcms\Content\Api\Component\BuildComponentObjectDefault;
use Zrcms\Content\Api\Component\FindComponent;
use Zrcms\Content\Api\Component\PrepareComponentConfig;
use Zrcms\Content\Api\Component\ReadComponentConfig;
use Zrcms\Content\Model\ServiceAliasComponent;
use Zrcms\ContentCore\Block\Api\Component\PrepareComponentConfigBlockBc;
use Zrcms\ContentCore\Block\Api\Component\ReadComponentConfigBlockBc;
use Zrcms\ContentCore\Block\Api\Component\ReadComponentConfigBlockBcFactory;
use Zrcms\ContentCore\Block\Api\GetBlockConfigFields;
use Zrcms\ContentCore\Block\Api\GetBlockConfigFieldsBcSubstitution;
use Zrcms\ContentCore\Block\Api\GetBlockData;
use Zrcms\ContentCore\Block\Api\GetBlockDataBasic;
use Zrcms\ContentCore\Block\Api\GetBlockDataNoop;
use Zrcms\ContentCore\Block\Api\GetMergedConfig;
use Zrcms\ContentCore\Block\Api\GetMergedConfigBasic;
use Zrcms\ContentCore\Block\Api\Render\GetBlockRenderTags;
use Zrcms\ContentCore\Block\Api\Render\GetBlockRenderTagsBasic;
use Zrcms\ContentCore\Block\Api\Render\RenderBlock;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBasic;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBc;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockBcFactory;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockMissing;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockMissingComment;
use Zrcms\ContentCore\Block\Api\Render\RenderBlockMustache;
use Zrcms\ContentCore\Block\Api\Render\WrapRenderedBlockVersion;
use Zrcms\ContentCore\Block\Api\Render\WrapRenderedBlockVersionLegacy;
use Zrcms\ContentCore\Block\Model\BlockComponent;
use Zrcms\ContentCore\Block\Model\BlockComponentBasic;
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
                    ReadComponentConfigBlockBc::class => [
                        'factory' => ReadComponentConfigBlockBcFactory::class
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
                            '1-' => FindComponent::class,
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
                            '0-' => FindComponent::class,
                        ],
                    ],
                    GetBlockData::class => [
                        'class' => GetBlockDataBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                            '1-' => FindComponent::class
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
                            '0-' => FindComponent::class
                        ],
                    ],
                    PrepareComponentConfigBlockBc::class => [
                        'arguments' => [
                            '0-' => GetBlockConfigFields::class,
                            '1-' => GetBlockConfigFieldsBcSubstitution::class,
                        ],
                    ],
                    PrepareComponentConfigBlockBc::class => [
                        'arguments' => [
                            '0-' => GetBlockConfigFields::class,
                            '1-' => GetBlockConfigFieldsBcSubstitution::class,
                        ],
                    ],
                    WrapRenderedBlockVersion::class => [
                        'class' => WrapRenderedBlockVersionLegacy::class,
                        'arguments' => [
                            '0-' => FindComponent::class
                        ],
                    ],
                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER => [
                    ReadComponentConfigBlockBc::SERVICE_ALIAS
                    => ReadComponentConfigBlockBc::class,
                ],
                // 'zrcms.block.content.renderer'
                ServiceAliasBlock::ZRCMS_CONTENT_RENDERER => [
                    'mustache' // RenderBlockMustache::SERVICE_ALIAS
                    => RenderBlockMustache::class,

                    RenderBlockBc::SERVICE_ALIAS
                    => RenderBlockBc::class,
                ],
                // 'zrcms.block.content.data-provider'
                ServiceAliasBlock::ZRCMS_CONTENT_DATA_PROVIDER => [
                    'noop'
                    => GetBlockDataNoop::class,
                ],
            ],
            /**
             * ===== ZRCMS Types =====
             */
            'zrcms-types' => [
                'block' => [
                    BuildComponentObject::class => BuildComponentObjectDefault::class,
                    PrepareComponentConfig::class => PrepareComponentConfigBlockBc::class,
                    ReadComponentConfig::class => ReadComponentConfigBlockBc::class,
                    'component-model-interface' => BlockComponent::class,
                    'component-model-class' => BlockComponentBasic::class,
                ]
            ],
        ];
    }
}
