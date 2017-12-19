<?php

namespace Zrcms\ViewHtmlTags\Api\Render;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderTag
{
    const OPTION_INDENT = 'indent';
    const OPTION_DEPTH = 'depth';
    const OPTION_LINE_BREAK = 'lineBreak';

    const PROPERTY_TAG = 'tag';
    const PROPERTY_ATTRIBUTES = 'attributes';
    const PROPERTY_CONTENT = 'content';

    /**
     * @param array $tagData
     * @param array $options
     *
     * @return string
     */
    public function __invoke(
        array $tagData,
        array $options = []
    ): string;
}
