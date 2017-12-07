<?php

namespace Zrcms\ViewHtmlTags;

use Zrcms\ViewHtmlTags\Api\Render\RenderTag;
use Zrcms\ViewHtmlTags\Api\Render\RenderTagBasic;
use Zrcms\ViewHtmlTags\Api\Render\RenderTags;
use Zrcms\ViewHtmlTags\Api\Render\RenderTagsBasic;

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
                    RenderTag::class => [
                        'class' => RenderTagBasic::class,
                    ],
                    RenderTags::class => [
                        'class' => RenderTagsBasic::class,
                        'arguments' => [
                            RenderTag::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
