<?php

namespace Zrcms\Content;

use Zrcms\Content\Api\ContentToArray;
use Zrcms\Content\Api\ContentToArrayBasic;
use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\Content\Api\ContentVersionToArrayBasic;
use Zrcms\Content\Api\CsmResourcePublishHistoryToArray;
use Zrcms\Content\Api\CsmResourcePublishHistoryToArrayBasic;
use Zrcms\Content\Api\CsmResourceToArray;
use Zrcms\Content\Api\CsmResourceToArrayBasic;

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
                    CsmResourcePublishHistoryToArray::class => [
                        'class' => CsmResourcePublishHistoryToArrayBasic::class
                    ],
                    CsmResourceToArray::class => [
                        'class' => CsmResourceToArrayBasic::class
                    ],
                ],
            ],
        ];
    }
}
