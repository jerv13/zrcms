<?php

namespace Zrcms\HttpAssets;

use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Api\GetComponentCss;
use Zrcms\Core\Api\GetComponentJs;
use Zrcms\HttpAssets\Api\GetCacheBreaker;
use Zrcms\HttpAssets\Api\GetCacheBreakerPhpFile;
use Zrcms\HttpAssets\Api\Render\RenderLinkHrefTag;
use Zrcms\HttpAssets\Api\Render\RenderScriptSrcTag;
use Zrcms\HttpAssets\Middleware\HttpComponentCss;
use Zrcms\HttpAssets\Middleware\HttpComponentJs;
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
                    RenderLinkHrefTag::class => [
                        'arguments' => [
                            RenderTag::class,
                            GetCacheBreaker::class
                        ],
                    ],
                    RenderScriptSrcTag::class => [
                        'arguments' => [
                            RenderTag::class,
                            GetCacheBreaker::class
                        ],
                    ],
                    GetCacheBreaker::class => [
                        'class' => GetCacheBreakerPhpFile::class,
                        'arguments' => [
                            ['literal' => __DIR__ . '/../../../../../releaseInfo.php']
                        ],
                    ],

                    /**
                     * Middleware
                     */
                    HttpComponentCss::class => [
                        'arguments' => [
                            FindComponentsBy::class,
                            GetComponentCss::class
                        ],
                    ],
                    HttpComponentJs::class => [
                        'arguments' => [
                            FindComponentsBy::class,
                            GetComponentJs::class
                        ],
                    ],
                ],
            ],
        ];
    }
}
