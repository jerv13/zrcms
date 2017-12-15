<?php

namespace Zrcms\ViewHead\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSectionsComposite implements GetSections
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
