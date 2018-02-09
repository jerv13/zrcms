<?php

namespace Zrcms\HttpAssets\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Render\Render;
use Zrcms\HttpAssets\Api\GetCacheBreaker;
use Reliv\ArrayProperties\Property;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLinkHrefTag implements Render
{
    const OPTION_HREF_ATTRIBUTE = 'href';
    const OPTION_MEDIA_ATTRIBUTE = 'media';
    const OPTION_REL_ATTRIBUTE = 'rel';
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
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function __invoke(
        ServerRequestInterface $request,
        $attributes,
        array $options = []
    ): string {
        Property::assertNotEmpty(
            $attributes,
            static::OPTION_HREF_ATTRIBUTE
        );

        $href = Property::getString(
            $attributes,
            static::OPTION_HREF_ATTRIBUTE
        );

        $attributes[static::OPTION_HREF_ATTRIBUTE]
            = $href . '?' . $this->getCacheBreaker->__invoke();

        $attributes[static::OPTION_MEDIA_ATTRIBUTE] = Property::getString(
            $attributes,
            static::OPTION_MEDIA_ATTRIBUTE,
            'screen,print'
        );

        $attributes[static::OPTION_REL_ATTRIBUTE] = Property::getString(
            $attributes,
            static::OPTION_REL_ATTRIBUTE,
            'stylesheet'
        );

        $attributes[static::OPTION_TYPE_ATTRIBUTE] = Property::getString(
            $attributes,
            static::OPTION_TYPE_ATTRIBUTE,
            'text/css'
        );

        return $this->renderTag->__invoke(
            [
                RenderTag::PROPERTY_TAG => 'link',
                RenderTag::PROPERTY_ATTRIBUTES => $attributes,
            ]
        );
    }
}
