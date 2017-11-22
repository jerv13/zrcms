<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\Block\Api\Component\GetRegisterBlockComponents;
use Zrcms\ContentCore\Block\Api\Component\ReadBlockComponentRegistry;
use Zrcms\ContentCore\Block\Api\PrepareBlockConfigBc;
use Zrcms\ContentCore\Block\Api\Component\FindBlockComponent;
use Zrcms\ContentCore\Block\Api\Component\FindBlockComponentsBy;
use Zrcms\ContentCoreConfigDataSource as This;
use Zrcms\ContentCoreConfigDataSource\Content\Api\SearchConfigList;

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
                    FindBlockComponent::class => [
                        'class' => This\Block\Api\Component\FindBlockComponent::class,
                        'arguments' => [
                            '0-' => GetRegisterBlockComponents::class,
                            '1-' => SearchConfigList::class,
                        ],
                    ],
                    FindBlockComponentsBy::class => [
                        'class' => This\Block\Api\Component\FindBlockComponentsBy::class,
                        'arguments' => [
                            '0-' => GetRegisterBlockComponents::class,
                            '1-' => SearchConfigList::class,
                        ],
                    ],
                    ReadBlockComponentRegistry::class => [
                        // @BC 'factory' => This\Block\Api\Repository\ReadBlockComponentRegistryBasicFactory::class,
                        'factory' => This\Block\Api\Component\ReadBlockComponentRegistryBcFactory::class,
                    ],
                    GetRegisterBlockComponents::class => [
                        'class' => This\Block\Api\Component\GetRegisterBlockComponentsBasic::class,
                        'arguments' => [
                            '0-' => PrepareBlockConfigBc::class,
                            '1-' => ReadBlockComponentRegistry::class,
                            '2-' => Cache::class,
                        ],
                    ],
                ],
            ],
            'zrcms-component-registry-readers' => [
                'blocks' => ReadBlockComponentRegistry::class,
            ],
            'zrcms-components' => [
                'blocks' => [
                    /*
                    '{block-name}' => '{block-location}(directory)'
                    OR
                    '{block-name}' => [
                      ComponentRegistryFields::CONFIG_LOCATION => '{block-location}(string)',
                      ComponentRegistryFields::COMPONENT_CONFIG_READER => '{block-location}(service-alias)',
                     ]
                    */
                ],
            ],
        ];
    }
}
