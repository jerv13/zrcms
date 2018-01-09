<?php

namespace Zrcms\Core\Api\Content;

use Zrcms\Core\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ContentToArray
{
    const OPTION_HIDE_PROPERTIES = 'hideProperties';

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
