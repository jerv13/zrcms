<?php

namespace Zrcms\CoreApplication\Api\Content;

use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\Core\Model\TrackableProperties;
use Zrcms\CoreApplication\Api\ArrayFromGetters;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentVersionToArrayBasic implements ContentVersionToArray
{
    const OPTION_HIDE_PROPERTIES = 'hideProperties';

    /**
     * @param ContentVersion $contentVersion
     * @param array          $options
     *
     * @return array
     */
    public function __invoke(
        ContentVersion $contentVersion,
        array $options = []
    ): array {
        $hideProperties = Param::getArray(
            $options,
            self::OPTION_HIDE_PROPERTIES,
            []
        );

        return ArrayFromGetters::invoke(
            $contentVersion,
            $hideProperties
        );
    }
}
