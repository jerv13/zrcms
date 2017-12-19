<?php

namespace Zrcms\HttpAssetsBlock\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Render\Render;
use Zrcms\Param\Param;
use Zrcms\HttpAssets\Api\GetCacheBreaker;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockCssTag implements Render
{
    const OPTION_CSS_URL = 'css-url';
    const OPTION_CSS_MEDIA_ATTRIBUTE = 'media';
    const OPTION_CSS_REL_ATTRIBUTE = 'rel';
    const OPTION_CSS_TYPE_ATTRIBUTE = 'type';

    protected $getCacheBreaker;

    public function __construct(
        GetCacheBreaker $getCacheBreaker
    ) {
        $this->getCacheBreaker = $getCacheBreaker;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array|mixed            $data
     * @param array                  $options
     *
     * @return string
     * @throws \Exception
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     * @throws \Zrcms\Param\Exception\ParamMissing
     */
    public function __invoke(
        ServerRequestInterface $request,
        $data,
        array $options = []
    ): string {
        Param::assertNotEmpty(
            $options,
            static::OPTION_CSS_URL
        );

        $jsUrl = Param::getString(
            $options,
            static::OPTION_CSS_URL
        );

        $media = Param::getString(
            $options,
            static::OPTION_CSS_MEDIA_ATTRIBUTE,
            'screen,print'
        );

        $rel = Param::getString(
            $options,
            static::OPTION_CSS_REL_ATTRIBUTE,
            'stylesheet'
        );

        $type = Param::getString(
            $options,
            static::OPTION_CSS_TYPE_ATTRIBUTE,
            'text/css'
        );

        $cacheBreaker = $this->getCacheBreaker->__invoke();

        return '<link href="' . $jsUrl . '?' . $cacheBreaker . '" media="' . $media . '" rel="' . $rel
            . '" type="' . $type . '">';
    }
}
