<?php

namespace Zrcms\HttpAssetsAdminTools;

use Zrcms\HttpAssetsAdminTools\Api\Render\RenderLinkHrefTagAdminTools;
use Zrcms\HttpAssetsAdminTools\Api\Render\RenderLinkHrefTagAdminToolsFactory;
use Zrcms\HttpAssetsAdminTools\Api\Render\RenderScriptSrcTagAdminTools;
use Zrcms\HttpAssetsAdminTools\Api\Render\RenderScriptSrcTagAdminToolsFactory;
use Zrcms\HttpAssetsAdminTools\Middleware\HttpAdminToolsComponentCss;
use Zrcms\HttpAssetsAdminTools\Middleware\HttpAdminToolsComponentCssFactory;
use Zrcms\HttpAssetsAdminTools\Middleware\HttpAdminToolsComponentJs;
use Zrcms\HttpAssetsAdminTools\Middleware\HttpAdminToolsComponentJsFactory;

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
                        'factory' => RenderLinkHrefTagAdminToolsFactory::class,
                    ],
                    RenderScriptSrcTagAdminTools::class => [
                        'factory' => RenderScriptSrcTagAdminToolsFactory::class,
                    ],
                    HttpAdminToolsComponentCss::class => [
                        'factory' => HttpAdminToolsComponentCssFactory::class,
                    ],
                    HttpAdminToolsComponentJs::class => [
                        'factory' => HttpAdminToolsComponentJsFactory::class,
                    ],
                ],
            ],
        ];
    }
}
