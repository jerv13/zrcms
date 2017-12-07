<?php

namespace Zrcms\CoreBlock;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Api\Component\PrepareComponentConfig;
use Zrcms\Core\Model\ServiceAliasComponent;
use Zrcms\CoreBlock\Api\Component\PrepareComponentConfigBlockBc;
use Zrcms\CoreBlock\Api\Component\ReadComponentConfigBlockBc;
use Zrcms\CoreBlock\Api\Component\ReadComponentConfigBlockBcFactory;
use Zrcms\CoreBlock\Api\GetBlockConfigFields;
use Zrcms\CoreBlock\Api\GetBlockConfigFieldsBcSubstitution;
use Zrcms\CoreBlock\Api\GetBlockData;
use Zrcms\CoreBlock\Api\GetBlockDataBasic;
use Zrcms\CoreBlock\Api\GetBlockDataNoop;
use Zrcms\CoreBlock\Api\GetMergedConfig;
use Zrcms\CoreBlock\Api\GetMergedConfigBasic;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTags;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTagsBasic;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\CoreBlock\Api\Render\RenderBlockBasic;
use Zrcms\CoreBlock\Api\Render\RenderBlockBc;
use Zrcms\CoreBlock\Api\Render\RenderBlockBcFactory;
use Zrcms\CoreBlock\Api\Render\RenderBlockMissing;
use Zrcms\CoreBlock\Api\Render\RenderBlockMissingComment;
use Zrcms\CoreBlock\Api\Render\RenderBlockMustache;
use Zrcms\CoreBlock\Api\Render\WrapRenderedBlockVersion;
use Zrcms\CoreBlock\Api\Render\WrapRenderedBlockVersionLegacy;
use Zrcms\CoreBlock\Model\BlockComponent;
use Zrcms\CoreBlock\Model\BlockComponentBasic;
use Zrcms\CoreBlock\Model\ServiceAliasBlock;
use Zrcms\Mustache\Resolver\FileResolver;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
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
                            GetBlockData::class,
                            GetMergedConfig::class,
                        ],
                    ],
                    RenderBlock::class => [
                        'class' => RenderBlockBasic::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                            FindComponent::class,
                            RenderBlockMissing::class,
                            ['literal' => RenderBlockMustache::class],
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
                            FindComponent::class,
                            FileResolver::class
                        ],
                    ],
                    GetBlockData::class => [
                        'class' => GetBlockDataBasic::class,
                        'arguments' => [
                            GetServiceFromAlias::class,
                            FindComponent::class
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
                            FindComponent::class
                        ],
                    ],
                    PrepareComponentConfigBlockBc::class => [
                        'arguments' => [
                            GetBlockConfigFields::class,
                            GetBlockConfigFieldsBcSubstitution::class,
                        ],
                    ],
                    PrepareComponentConfigBlockBc::class => [
                        'arguments' => [
                            GetBlockConfigFields::class,
                            GetBlockConfigFieldsBcSubstitution::class,
                        ],
                    ],
                    WrapRenderedBlockVersion::class => [
                        'class' => WrapRenderedBlockVersionLegacy::class,
                        'arguments' => [
                            FindComponent::class
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
                    PrepareComponentConfig::class => PrepareComponentConfigBlockBc::class,
                    'component-model-interface' => BlockComponent::class,
                    'component-model-class' => BlockComponentBasic::class,
                ]
            ],
        ];
    }
}
