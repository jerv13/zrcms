<?php

namespace Zrcms\Content;

use Zrcms\Content\Api\CmsResourceHistoryToArray;
use Zrcms\Content\Api\CmsResourceHistoryToArrayBasic;
use Zrcms\Content\Api\CmsResourceToArray;
use Zrcms\Content\Api\CmsResourceToArrayBasic;
use Zrcms\Content\Api\ComponentToArray;
use Zrcms\Content\Api\ComponentToArrayBasic;
use Zrcms\Content\Api\ContentToArray;
use Zrcms\Content\Api\ContentToArrayBasic;
use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\Content\Api\ContentVersionToArrayBasic;

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
                    CmsResourceHistoryToArray::class => [
                        'class' => CmsResourceHistoryToArrayBasic::class,
                        'arguments' => [
                            ContentVersionToArray::class
                        ],
                    ],
                    CmsResourceToArray::class => [
                        'class' => CmsResourceToArrayBasic::class,
                        'arguments' => [
                            ContentVersionToArray::class
                        ],
                    ],
                    ComponentToArray::class => [
                        'class' => ComponentToArrayBasic::class,
                    ],
                    ContentToArray::class => [
                        'class' => ContentToArrayBasic::class
                    ],
                    ContentVersionToArray::class => [
                        'class' => ContentVersionToArrayBasic::class
                    ],
                ],
            ],
        ];
    }
}
