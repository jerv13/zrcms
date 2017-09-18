<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\Content;
use Zrcms\Content\Model\Properties;
use Zrcms\Content\Fields\FieldsContent;

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
            FieldsContent::ID
            => $content->getId(),

            Properties::NAME_PROPERTIES
            => $content->getProperties()
        ];
    }
}
