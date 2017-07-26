<?php

namespace Zrcms\RcmPluginCompatibility;

use Zrcms\ContentCoreConfigDataSource\Block\Api\FindBlocksBy;
use Zrcms\RcmPluginCompatibility\Block\Api\FindBlockByRcmLegacy;
use Zrcms\RcmPluginCompatibility\Block\Api\FindBlockRcmLegacy;
use Zrcms\RcmPluginCompatibility\Block\Api\FindBlocksByRcmLegacy;
use Zrcms\RcmPluginCompatibility\Block\Internal\ConfigFields;
use Zrcms\RcmPluginCompatibility\Block\Internal\ConfigRepository;
use Zrcms\Cache\Service;

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
                    FindBlocksByRcmLegacy::class => [
                        'arguments' => [
                            ConfigRepository::class
                        ]
                    ],
                    FindBlockRcmLegacy::class => [
                        'arguments' => [
                            ConfigRepository::class
                        ]
                    ],
                    ConfigFields::class => [],
                    ConfigRepository::class => [
                        'arguments' => [
                            'config',
                            Cache::class,
                            ConfigFields::class,
                            FindBlocksBy::class
                        ]
                    ],
                ]
            ]
        ];
    }
}
