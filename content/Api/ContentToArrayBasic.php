<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\Content;
use Zrcms\Content\Model\Properties;
use Zrcms\Content\Model\PropertiesContent;

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
    ): array
    {
        return [
            PropertiesContent::ID
            => $content->getId(),

            Properties::NAME_PROPERTIES
            => $content->getProperties()
        ];
    }
}
