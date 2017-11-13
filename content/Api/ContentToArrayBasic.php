<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentToArrayBasic implements ContentToArray
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
    ): array {
        return [
            'id' => $content->getId(),

            'properties'
            => $content->getProperties()
        ];
    }
}
