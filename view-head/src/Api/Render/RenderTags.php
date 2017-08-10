<?php

namespace Zrcms\ViewHead\Api\Render;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderTags
{
    /**
     * @param array $tagsData
     * @param array $options
     *
     * @return string
     */
    public function __invoke(
        array $tagsData,
        array $options = []
    ): string;
}
