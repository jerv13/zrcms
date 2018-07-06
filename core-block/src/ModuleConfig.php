<?php

namespace Zrcms\CoreBlock;

use Zrcms\CoreBlock\Api\Component\PrepareComponentConfigBlock;
use Zrcms\CoreBlock\Api\Component\PrepareComponentConfigBlockBc;
use Zrcms\CoreBlock\Api\Component\PrepareComponentConfigBlockBcFactory;
use Zrcms\CoreBlock\Api\Component\PrepareComponentConfigBlockFieldsToDefaultConfig;
use Zrcms\CoreBlock\Api\Component\PrepareComponentConfigBlockFieldsToDefaultConfigFactory;
use Zrcms\CoreBlock\Api\Component\ReadComponentConfigBlockBc;
use Zrcms\CoreBlock\Api\Component\ReadComponentConfigBlockBcFactory;
use Zrcms\CoreBlock\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\CoreBlock\Api\Component\ReadComponentConfigJsonFileBc;
use Zrcms\CoreBlock\Api\Component\ReadComponentConfigJsonFileBcFactory;
use Zrcms\CoreBlock\Api\Component\ReadComponentConfigJsonFileFactory;
use Zrcms\CoreBlock\Api\Component\ReadComponentRegistryRcmPluginBc;
use Zrcms\CoreBlock\Api\Component\ReadComponentRegistryRcmPluginBcFactory;
use Zrcms\CoreBlock\Api\GetBlockConfigFields;
use Zrcms\CoreBlock\Api\GetBlockConfigFieldsBcSubstitution;
use Zrcms\CoreBlock\Api\GetBlockData;
use Zrcms\CoreBlock\Api\GetBlockDataBasicFactory;
use Zrcms\CoreBlock\Api\GetBlockDataNoop;
use Zrcms\CoreBlock\Api\GetMergedConfig;
use Zrcms\CoreBlock\Api\GetMergedConfigBasicFactory;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTags;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTagsBasicFactory;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\CoreBlock\Api\Render\RenderBlockBasicFactory;
use Zrcms\CoreBlock\Api\Render\RenderBlockBc;
use Zrcms\CoreBlock\Api\Render\RenderBlockBcFactory;
use Zrcms\CoreBlock\Api\Render\RenderBlockMissing;
use Zrcms\CoreBlock\Api\Render\RenderBlockMissingDiv;
use Zrcms\CoreBlock\Api\Render\RenderBlockMustache;
use Zrcms\CoreBlock\Api\Render\RenderBlockMustacheFactory;
use Zrcms\CoreBlock\Api\Render\WrapRenderedBlockVersion;
use Zrcms\CoreBlock\Api\Render\WrapRenderedBlockVersionLegacyFactory;

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
                    /**
                     * Component
                     */
                    PrepareComponentConfigBlock::class => [
                        'factory' => PrepareComponentConfigBlockBcFactory::class,
                    ],

                    PrepareComponentConfigBlockBc::class => [
                        'factory' => PrepareComponentConfigBlockBcFactory::class,
                    ],

                    PrepareComponentConfigBlockFieldsToDefaultConfig::class => [
                        'factory' => PrepareComponentConfigBlockFieldsToDefaultConfigFactory::class,
                    ],

                    ReadComponentConfigBlockBc::class => [
                        'factory' => ReadComponentConfigBlockBcFactory::class,
                    ],
                    ReadComponentConfigJsonFile::class => [
                        'factory' => ReadComponentConfigJsonFileFactory::class,
                    ],

                    ReadComponentConfigJsonFileBc::class => [
                        'factory' => ReadComponentConfigJsonFileBcFactory::class,
                    ],

                    ReadComponentRegistryRcmPluginBc::class => [
                        'factory' => ReadComponentRegistryRcmPluginBcFactory::class,
                    ],
                    /**
                     * Render
                     */
                    GetBlockRenderTags::class => [
                        'factory' => GetBlockRenderTagsBasicFactory::class,
                    ],
                    RenderBlock::class => [
                        'factory' => RenderBlockBasicFactory::class,
                    ],
                    RenderBlockBc::class => [
                        'factory' => RenderBlockBcFactory::class,
                    ],
                    RenderBlockMissing::class => [
                        'class' => RenderBlockMissingDiv::class,
                    ],
                    RenderBlockMustache::class => [
                        'factory' => RenderBlockMustacheFactory::class,
                    ],
                    WrapRenderedBlockVersion::class => [
                        'factory' => WrapRenderedBlockVersionLegacyFactory::class,
                    ],

                    /**
                     * API General
                     */
                    GetBlockConfigFields::class => [
                        'class' => GetBlockConfigFields::class,
                    ],
                    GetBlockConfigFieldsBcSubstitution::class => [
                        'class' => GetBlockConfigFieldsBcSubstitution::class,
                    ],
                    GetBlockData::class => [
                        'factory' => GetBlockDataBasicFactory::class,
                    ],
                    GetBlockDataNoop::class => [],
                    GetMergedConfig::class => [
                        'factory' => GetMergedConfigBasicFactory::class,
                    ],
                ],
            ],
        ];
    }
}
