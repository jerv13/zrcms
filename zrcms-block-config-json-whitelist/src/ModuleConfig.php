<?php

namespace Zrcms\BlockConfigJsonWhitelist;

use Reliv\WhiteRat\Filter;
use Zrcms\BlockConfigJsonWhitelist\Api\Render\FilterWithWhitelistInterface;
use Zrcms\BlockConfigJsonWhitelist\Api\Render\GetBlockRenderTagsConfigJsonWhitelist;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreBlock\Api\GetBlockData;
use Zrcms\CoreBlock\Api\GetMergedConfig;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTags;

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
                    GetBlockRenderTags::class => [
                        'class' => GetBlockRenderTagsConfigJsonWhitelist::class,
                        'arguments' => [
                            GetBlockData::class,
                            GetMergedConfig::class,
                            FindComponent::class,
                            FilterWithWhitelistInterface::class
                        ],
                    ],

                    FilterWithWhitelistInterface::class => [
                        'class' => Filter::class
                    ],
                ],
            ],
        ];
    }
}
