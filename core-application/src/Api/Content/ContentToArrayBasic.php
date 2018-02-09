<?php

namespace Zrcms\CoreApplication\Api\Content;

use Zrcms\Core\Api\Content\ContentToArray;
use Zrcms\Core\Model\Content;
use Zrcms\CoreApplication\Api\ArrayFromGetters;
use Zrcms\CoreApplication\Api\RemoveProperties;
use Reliv\ArrayProperties\Property;

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
     * @throws \Exception
     */
    public function __invoke(
        Content $content,
        array $options = []
    ): array {
        $array = [];

        $array['id'] = $content->getId();
        $array['properties'] = $content->getProperties();

        return RemoveProperties::invoke(
            $array,
            Property::getArray(
                $options,
                self::OPTION_HIDE_PROPERTIES,
                []
            )
        );
    }
}
