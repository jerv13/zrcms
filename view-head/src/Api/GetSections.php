<?php

namespace Zrcms\ViewHead\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetSections
{
    /**
     * @param string $tagType
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        string $tagType,
        array  $options = []
    ):array;
}
