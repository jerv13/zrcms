<?php

namespace Zrcms\ViewMetaPageData;

use Zrcms\Acl\Api\IsAllowedAny;
use Zrcms\Debug\IsDebug;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;
use Zrcms\ViewMetaPageData\Api\View\Render\GetViewLayoutMetaPageData;

/**
 * @deprecated BC ONLY - Use \Zrcms\HttpAssetsApplicationState
 * @author     James Jervis - https://github.com/jerv13
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
                     * Api ===========================================
                     */
                    GetViewLayoutMetaPageData::class => [
                        'arguments' => [
                            RenderTag::class,
                            // @todo Real ACL??
                            IsAllowedAny::class,
                            ['literal' => []],
                            ['literal' => IsDebug::invoke()],
                        ],
                    ],
                ],
            ],
        ];
    }
}
