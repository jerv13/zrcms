<?php

namespace Zrcms\BlockConfigJsonWhitelist;

use Reliv\WhiteRat\Filter;
use Zrcms\BlockConfigJsonWhitelist\Api\Render\FilterWithWhitelistInterface;
use Zrcms\BlockConfigJsonWhitelist\Api\Render\GetBlockRenderTagsConfigJsonWhitelistFactory;
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
                        'factory' => GetBlockRenderTagsConfigJsonWhitelistFactory::class,
                    ],

                    FilterWithWhitelistInterface::class => [
                        'class' => Filter::class
                    ],
                ],
            ],
        ];
    }
}
