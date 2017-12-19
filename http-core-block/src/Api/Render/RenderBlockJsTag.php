<?php

namespace Zrcms\HttpCoreBlock\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Render\Render;
use Zrcms\Param\Param;
use Zrcms\ViewAssets\Api\GetCacheBreaker;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockJsTag implements Render
{
    const OPTION_JS_URL = 'js-url';
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
            static::OPTION_JS_URL
        );

        $jsUrl = Param::getString(
            $options,
            static::OPTION_JS_URL
        );

        $type = Param::getString(
            $options,
            static::OPTION_CSS_TYPE_ATTRIBUTE,
            'text/javascript'
        );

        $cacheBreaker = $this->getCacheBreaker->__invoke();

        return '<script type="' . $type . '" src="' . $jsUrl . '?' . $cacheBreaker . '"></script>';
    }
}
