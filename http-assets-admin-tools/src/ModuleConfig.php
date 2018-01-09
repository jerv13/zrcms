<?php

namespace Zrcms\HttpAssetsAdminTools;

use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminToolsRcmUserSitesAdmin;
use Zrcms\CoreAdminTools\Api\GetComponentCssAdminTools;
use Zrcms\CoreAdminTools\Api\GetComponentJsAdminTools;
use Zrcms\Debug\IsDebug;
use Zrcms\HttpAssets\Api\GetCacheBreaker;
use Zrcms\HttpAssetsAdminTools\Api\Render\RenderLinkHrefTagAdminTools;
use Zrcms\HttpAssetsAdminTools\Api\Render\RenderScriptSrcTagAdminTools;
use Zrcms\HttpAssetsAdminTools\Middleware\HttpAdminToolsComponentCss;
use Zrcms\HttpAssetsAdminTools\Middleware\HttpAdminToolsComponentJs;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

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
                    RenderLinkHrefTagAdminTools::class => [
                        'arguments' => [
                            IsAllowedAdminToolsRcmUserSitesAdmin::class,
                            ['literal' => []],
                            RenderTag::class,
                            GetCacheBreaker::class,
                            ['literal' => IsDebug::invoke()],
                        ],
                    ],
                    RenderScriptSrcTagAdminTools::class => [
                        'arguments' => [
                            IsAllowedAdminToolsRcmUserSitesAdmin::class,
                            ['literal' => []],
                            RenderTag::class,
                            GetCacheBreaker::class,
                            ['literal' => IsDebug::invoke()],
                        ],
                    ],
                    HttpAdminToolsComponentCss::class => [
                        'arguments' => [
                            FindComponentsBy::class,
                            GetComponentCssAdminTools::class,
                        ],
                    ],
                    HttpAdminToolsComponentJs::class => [
                        'arguments' => [
                            FindComponentsBy::class,
                            GetComponentJsAdminTools::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
