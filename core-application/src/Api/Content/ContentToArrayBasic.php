<?php

namespace Zrcms\CoreApplication\Api\Content;

use Zrcms\Core\Api\Content\ContentToArray;
use Zrcms\Core\Model\Content;
use Zrcms\CoreApplication\Api\ArrayFromGetters;
use Zrcms\Param\Param;

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
        $hideProperties = Param::getArray(
            $options,
            self::OPTION_HIDE_PROPERTIES,
            []
        );

        return ArrayFromGetters::invoke(
            $content,
            $hideProperties
        );
    }
}
