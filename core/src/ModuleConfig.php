<?php

namespace Zrcms\Core;

use Zrcms\Core\Api\ChangeLog\GetChangeLogByDateRange;
use Zrcms\Core\Api\CmsResource\CmsResourcesToArray;
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
use Zrcms\Core\Api\GetComponentCss;
use Zrcms\Core\Api\GetComponentJs;
use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Exception\IMPLEMENTATIONisREQUIRED;

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
                     * ChangeLog
                     */
                    GetChangeLogByDateRange::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * CmsResource
                     */
                    CmsResourcesToArray::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    CmsResourceToArray::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * CmsResourceHistory
                     */
                    CmsResourceHistoryToArray::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * Component
                     */
                    BuildComponentObject::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    ComponentToArray::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindComponent::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    FindComponentsBy::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    ReadComponentConfig::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    ReadComponentConfigs::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    ReadComponentRegistry::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * Content
                     */
                    ContentToArray::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    ContentVersionToArray::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],

                    /**
                     * General
                     */
                    GetTypeValue::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    GetComponentCss::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ],
                    GetComponentJs::class => [
                        'class' => IMPLEMENTATIONisREQUIRED::class
                    ]
                ],
            ],
        ];
    }
}
