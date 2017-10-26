<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zrcms\ContentCoreConfigDataSource as This;

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
        $config = [
            /**
             * ===== ReadComponentRegistry service registry =====
             */
            'zrcms-component-registry-readers' => [
                /*
                'example' => ReadComponentRegistry::class,
                 */
            ],

            'zrcms-components' => [
                /*
                'example' => [
                    '{basic-name}' => '{basic-location}(directory)',
                    // OR
                    '{basic-name}' => [
                        ComponentRegistryFields::CONFIG_LOCATION => '{basic-location}(string)',
                        ComponentRegistryFields::COMPONENT_CONFIG_READER => '{basic-location}(service-alias)',
                    ],
                ],
                 */
            ],
        ];

        $zrcmsModules = [
            new ArrayProvider($config),
            new ModuleConfigBasic(),
            new ModuleConfigBlock(),
            new ModuleConfigContent(),
            new ModuleConfigTheme(),
            new ModuleConfigView(),
        ];

        $configManager = new ConfigAggregator(
            $zrcmsModules
        );

        return $configManager->getMergedConfig();
    }
}
