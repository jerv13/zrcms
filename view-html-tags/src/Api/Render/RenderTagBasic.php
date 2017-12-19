<?php

namespace Zrcms\ViewHtmlTags\Api\Render;

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
     * @param array  $selfClosingTags
     * @param string $encoding
     */
    public function __construct(
        array $selfClosingTags = [],
        string $encoding = 'UTF-8'
    ) {
        if (!empty($selfClosingTags)) {
            $this->selfClosingTags = $selfClosingTags;
        }
    }

    /**
     * @param array $tagData
     * @param array $options
     *
     * @return string
     * @throws \Exception
     * @throws \Zrcms\Param\Exception\ParamMissing
     */
    public function __invoke(
        array $tagData,
        array $options = []
    ): string {
        $tag = Param::getRequired($tagData, self::PROPERTY_TAG);
        $attributes = Param::getArray($tagData, self::PROPERTY_ATTRIBUTES, []);
        $contentHtml = Param::getString($tagData, self::PROPERTY_CONTENT, '');
        $depth = Param::getInt(
            $options,
            RenderTag::OPTION_DEPTH,
            1
        );
        $indent = Param::getString(
            $options,
            self::OPTION_INDENT,
            ''
        );

        $indent = $this->getIndent($indent, $depth);

        $lineBreak = Param::getString(
            $options,
            self::OPTION_LINE_BREAK,
            "\n"
        );

        return $this->renderTag(
            $tag,
            $attributes,
            $contentHtml,
            $indent,
            $lineBreak
        );
    }

    /**
     * @param string $tag
     * @param array  $attributes
     * @param null   $contentHtml
     * @param string $indent
     * @param string $lineBreak
     *
     * @return string
     */
    protected function renderTag(
        string $tag,
        array $attributes,
        $contentHtml = null,
        string $indent = '    ',
        string $lineBreak = "\n"
    ): string {
        $attributeHtml = $this->buildAttributes($attributes);

        if (!$this->canSelfClose($tag, $contentHtml)) {
            $contentHtml = (string)$contentHtml;
            $html = $indent . '<' . $tag . $attributeHtml . '>' . $contentHtml . '</' . $tag . '>' . $lineBreak;
        } else {
            $html = $indent . '<' . $tag . $attributeHtml . '/>' . $lineBreak;
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
            $html .= (string)$attribute . '="' . htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8', false) . '"';

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

    /**
     * @param string $indent
     * @param int    $depth
     *
     * @return string
     */
    protected function getIndent(string $indent, int $depth): string
    {
        return str_repeat($indent, $depth);
    }
}
