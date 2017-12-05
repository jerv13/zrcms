<?php

namespace Zrcms\ContentCoreConfigDataSource;

use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\View\Api\Component\ReadViewLayoutTagsComponentRegistry;
use Zrcms\ContentCore\View\Api\GetRegisterViewLayoutTagsComponents;
use Zrcms\ContentCore\View\Api\Component\FindViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Api\Component\FindViewLayoutTagsComponentsBy;
use Zrcms\ContentCoreConfigDataSource as This;
use Zrcms\Content\Api\Component\SearchComponentListBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigView
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    FindViewLayoutTagsComponent::class => [
                        'class' => This\View\Api\Component\FindViewLayoutTagsComponent::class,
                        'arguments' => [
                            '0-' => GetRegisterViewLayoutTagsComponents::class,
                            '1-' => SearchComponentListBasic::class
                        ],
                    ],
                    FindViewLayoutTagsComponentsBy::class => [
                        'class' => This\View\Api\Component\FindViewLayoutTagsComponentsBy::class,
                        'arguments' => [
                            '0-' => GetRegisterViewLayoutTagsComponents::class,
                            '1-' => SearchComponentListBasic::class
                        ],
                    ],
                    ReadViewLayoutTagsComponentRegistry::class => [
                        'factory'
                        => This\View\Api\Component\ReadViewLayoutTagsComponentRegistryBasicFactory::class,

                    ],
                    GetRegisterViewLayoutTagsComponents::class => [
                        'class' => This\View\Api\Component\GetRegisterViewLayoutTagsComponentsBasic::class,
                        'arguments' => [
                            '0-' => ReadViewLayoutTagsComponentRegistry::class,
                            '1-' => Cache::class
                        ],
                    ],
                ],
            ],
            'zrcms-components' => [
                'view-layout-tags' => [
                    /*
                     '{view-layout-tags-name}' => '{view-layout-tags-getter-location}(directory)'
                     OR
                     '{view-layout-tags-name}' => [
                       ComponentRegistryFields::CONFIG_LOCATION => '{view-layout-tags-location}(string)',
                       ComponentRegistryFields::COMPONENT_CONFIG_READER => '{view-layout-tags-location}(service-alias)',
                      ]
                     */
                ],
            ],
        ];
    }
}
