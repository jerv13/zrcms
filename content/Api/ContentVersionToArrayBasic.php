<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\ContentVersion;
use Zrcms\Content\Model\OptionsToArray;
use Zrcms\Content\Model\Properties;
use Zrcms\Content\Fields\FieldsContent;
use Zrcms\Content\Model\Trackable;
use Zrcms\Content\Model\TrackableProperties;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentVersionToArrayBasic implements ContentVersionToArray
{
    /**
     * @param ContentVersion $contentVersion
     * @param array          $options
     *
     * @return array
     */
    public function __invoke(
        ContentVersion $contentVersion,
        array $options = []
    ): array
    {
        $dateFormat = Param::get(
            $options,
            OptionsToArray::CREATED_DATE_FORMAT,
            Trackable::DATE_FORMAT
        );

        return [
            'id'
            => $contentVersion->getId(),

            'properties'
            => $contentVersion->getProperties(),

            TrackableProperties::CREATED_BY_USER_ID
            => $contentVersion->getCreatedByUserId(),

            TrackableProperties::CREATED_REASON
            => $contentVersion->getCreatedReason(),

            TrackableProperties::CREATED_DATE
            => $contentVersion->getCreatedDate(),
        ];
    }
}
