<?php

namespace Zrcms\HttpAssets;

use Zrcms\HttpAssets\Api\GetCacheBreaker;
use Zrcms\HttpAssets\Api\GetCacheBreakerPhpFile;
use Zrcms\HttpAssets\Api\Render\RenderLinkHrefTag;
use Zrcms\HttpAssets\Api\Render\RenderScriptSrcTag;
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
                ],
            ],
        ];
    }
}
