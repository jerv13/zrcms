<?php

namespace Zrcms\Content\Api\Content;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ContentToArray
{
    /**
     * @param Content $content
     * @param array   $options
     *
     * @return array
     */
    public function __invoke(
        Content $content,
        array $options = []
    ): array;
}
