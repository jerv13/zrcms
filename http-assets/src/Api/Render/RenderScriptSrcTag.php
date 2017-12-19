<?php

namespace Zrcms\HttpAssets\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Render\Render;
use Zrcms\HttpAssets\Api\GetCacheBreaker;
use Zrcms\Param\Param;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderScriptSrcTag implements Render
{
    const OPTION_SRC_ATTRIBUTE = 'src';
    const OPTION_TYPE_ATTRIBUTE = 'type';

    protected $renderTag;
    protected $getCacheBreaker;

    /**
     * @param RenderTag       $renderTag
     * @param GetCacheBreaker $getCacheBreaker
     */
    public function __construct(
        RenderTag $renderTag,
        GetCacheBreaker $getCacheBreaker
    ) {
        $this->renderTag = $renderTag;
        $this->getCacheBreaker = $getCacheBreaker;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array|mixed            $attributes
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
        $attributes,
        array $options = []
    ): string {
        Param::assertNotEmpty(
            $attributes,
            static::OPTION_SRC_ATTRIBUTE
        );

        $src = Param::getString(
            $attributes,
            static::OPTION_SRC_ATTRIBUTE
        );

        $attributes[static::OPTION_SRC_ATTRIBUTE]
            = $src . '?' . $this->getCacheBreaker->__invoke();

        $attributes[static::OPTION_TYPE_ATTRIBUTE] = Param::getString(
            $attributes,
            static::OPTION_TYPE_ATTRIBUTE,
            'text/javascript'
        );

        return $this->renderTag->__invoke(
            [
                RenderTag::PROPERTY_TAG => 'script',
                RenderTag::PROPERTY_ATTRIBUTES => $attributes,
            ]
        );
    }
}
