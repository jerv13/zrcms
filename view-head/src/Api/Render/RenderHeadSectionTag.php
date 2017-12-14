<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ViewHead\Api\Exception\CanNotRenderHeadSectionTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderHeadSectionTag
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
    ): string;
}
