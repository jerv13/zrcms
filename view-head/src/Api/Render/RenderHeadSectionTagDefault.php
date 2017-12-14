<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagDefault
{
    protected $renderTag;
    protected $getAvailableHeadSections;
    protected $getServiceFromAlias;
    protected $serviceAliasNamespace;

    /**
     * @param RenderTag $renderTag
     */
    public function __construct(
        RenderTag $renderTag
    ) {
        $this->renderTag = $renderTag;
    }

    /**
     * @param ServerRequestInterface $request
     * @param string                 $tag
     * @param string                 $sectionEntryName
     * @param array                  $attributes
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $tag,
        string $sectionEntryName,
        array $attributes,
        array $options = []
    ): string {
        // general - Render from a tag configuration
        $contentHtml = null;
        if (array_key_exists('__content', $attributes)) {
            $contentHtml = (string)$attributes['__content'];
        }

        $attributes = $this->cleanAttributes($attributes);

        return $this->renderTag->__invoke(
            [
                'tag' => $tag,
                'attributes' => $attributes,
                'content' => $contentHtml
            ],
            $options
        );
    }

    /**
     * @param $attributes
     *
     * @return mixed
     */
    protected function cleanAttributes($attributes)
    {
        foreach ($attributes as $key => $attribute) {
            if (strpos($key, '__')) {
                unset($attributes[$key]);
            }
        }

        return $attributes;
    }
}
