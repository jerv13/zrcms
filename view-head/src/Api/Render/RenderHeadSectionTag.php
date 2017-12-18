<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderHeadSectionTag
{
    const OPTION_INDENT = RenderTag::OPTION_INDENT;
    const OPTION_LINE_BREAK = RenderTag::OPTION_LINE_BREAK;
    const OPTION_DEBUG = 'debug';

    /**
     * @param ServerRequestInterface $request
     * @param string                 $tag
     * @param string                 $sectionEntryName
     * @param array                  $sectionConfig
     * @param array                  $options
     *
     * @return string
     * @throws CanNotRenderHeadSectionTag
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $tag,
        string $sectionEntryName,
        array $sectionConfig,
        array $options = []
    ): string;
}
