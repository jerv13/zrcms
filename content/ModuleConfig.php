<?php

namespace Zrcms\Content;

use Zrcms\Content\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Content\Api\CmsResourceHistory\CmsResourceHistoryToArrayBasic;
use Zrcms\Content\Api\CmsResource\CmsResourceToArray;
use Zrcms\Content\Api\CmsResource\CmsResourceToArrayBasic;
use Zrcms\Content\Api\Component\ComponentToArray;
use Zrcms\Content\Api\Component\ComponentToArrayBasic;
use Zrcms\Content\Api\Content\ContentToArray;
use Zrcms\Content\Api\Content\ContentToArrayBasic;
use Zrcms\Content\Api\Content\ContentVersionToArray;
use Zrcms\Content\Api\Content\ContentVersionToArrayBasic;

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
