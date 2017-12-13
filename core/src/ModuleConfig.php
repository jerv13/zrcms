<?php

namespace Zrcms\Core;

use Zrcms\Core\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Api\Component\ReadComponentConfigs;
use Zrcms\Core\Api\Component\ReadComponentRegistry;
use Zrcms\Core\Api\Content\ContentToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Exception\IMPLEMENTATION_REQUIRED;

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
        return [
            'dependencies' => [
                'config_factories' => [
                    /**
                     * ChangeLog
                     */
                    GetChangeLogByDateRange::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],

                    /**
                     * CmsResource
                     */
                    CmsResourceToArray::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],

                    /**
                     * CmsResourceHistory
                     */
                    CmsResourceHistoryToArray::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],

                    /**
                     * Component
                     */
                    BuildComponentObject::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    ComponentToArray::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindComponent::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    FindComponentsBy::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],

                    ReadComponentConfig::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    ReadComponentConfigs::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    ReadComponentRegistry::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],

                    /**
                     * Content
                     */
                    ContentToArray::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],
                    ContentVersionToArray::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ],

                    /**
                     * General
                     */
                    GetTypeValue::class => [
                        'class' => IMPLEMENTATION_REQUIRED::class
                    ]
                ],
            ],
        ];
    }
}
