<?php

namespace Zrcms\ViewHead\Api\Render;

use Zrcms\Content\Model\Content;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderTagBasic implements RenderTag
{
    /**
     * @var array
     */
    protected $selfClosingTags
        = [
            'area',
            'base',
            'basefont',
            'br',
            'hr',
            'input',
            'img',
            'link',
            'meta',
        ];

    /**
     * @param array $selfClosingTags
     */
    public function __construct(array $selfClosingTags = [])
    {
        if (!empty($selfClosingTags)) {
            $this->selfClosingTags = $selfClosingTags;
        }
    }

    /**
     * @param array $tagData
     * @param array $options
     *
     * @return string
     */
    public function __invoke(
        array $tagData,
        array $options = []
    ): string
    {
        $tag = Param::getRequired($tagData, 'tag');
        $attributes = Param::getArray($tagData, 'attributes', []);
        $contentHtml = Param::getString($tagData, 'content', '');

        return $this->renderTag($tag, $attributes, $contentHtml);
    }

    /**
     * @param string $tag
     * @param array  $attributes
     * @param null   $contentHtml
     *
     * @return string
     */
    protected function renderTag(string $tag, array $attributes, $contentHtml = null): string
    {
        $attributeHtml = $this->buildAttributes($attributes);

        if (!$this->canSelfClose($tag, $contentHtml)) {
            $contentHtml = (string)$contentHtml;
            $html = '<' . $tag . $attributeHtml . '>' . $contentHtml . '</' . $tag . '>';
        } else {
            $html = '<' . $tag . $attributeHtml . '/>';
        }

        return $html;
    }

    /**
     * @param array $attributes
     *
     * @return string
     */
    protected function buildAttributes(array $attributes): string
    {
        $html = '';
        $count = count($attributes);
        $index = 1;

        foreach ($attributes as $attribute => $value) {
            // leading space
            if ($index === 1) {
                $html .= ' ';
            }
            $html .= (string)$attribute . '="' . (string)$value . '"';

            // trailing space
            if ($index < $count) {
                $html .= ' ';
            }
            $index++;
        }

        return $html;
    }

    /**
     * @param string $tag
     * @param null   $content
     *
     * @return bool
     */
    protected function canSelfClose(string $tag, $content = null): bool
    {
        return (in_array($tag, $this->selfClosingTags) && empty($content));
    }
}
