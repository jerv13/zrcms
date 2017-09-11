<?php

namespace Zrcms\Content;

use Zrcms\Content\Api\ContentToArray;
use Zrcms\Content\Api\ContentToArrayBasic;
use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\Content\Api\ContentVersionToArrayBasic;
use Zrcms\Content\Api\CmsResourcePublishHistoryToArray;
use Zrcms\Content\Api\CmsResourcePublishHistoryToArrayBasic;
use Zrcms\Content\Api\CmsResourceToArray;
use Zrcms\Content\Api\CmsResourceToArrayBasic;

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
                    ContentToArray::class => [
                        'class' => ContentToArrayBasic::class
                    ],
                    ContentVersionToArray::class => [
                        'class' => ContentVersionToArrayBasic::class
                    ],
                    CmsResourcePublishHistoryToArray::class => [
                        'class' => CmsResourcePublishHistoryToArrayBasic::class,
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
                ],
            ],
        ];
    }
}
