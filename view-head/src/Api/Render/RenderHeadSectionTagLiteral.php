<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Param\Param;
use Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagLiteral implements RenderHeadSectionTag
{
    /**
     * @param ServerRequestInterface $request
     * @param string                 $tag
     * @param string                 $sectionEntryName
     * @param array                  $attributes
     * @param array                  $options
     *
     * @return string
     * @throws CanNotRenderHeadSectionTag
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $tag,
        string $sectionEntryName,
        array $attributes,
        array $options = []
    ): string {
        // literal - Render a string as it is in the config
        if (!array_key_exists('__literal', $attributes)) {
            throw new CanNotRenderHeadSectionTag('Does not have required key: (__literal)');
        }

        $indent = Param::getString(
            $options,
            RenderTag::OPTION_INDENT,
            '    '
        );
        $lineBreak = Param::getString(
            $options,
            RenderTag::OPTION_LINE_BREAK,
            "\n"
        );

        return $indent . (string)$attributes['__literal'] . $lineBreak;
    }
}
