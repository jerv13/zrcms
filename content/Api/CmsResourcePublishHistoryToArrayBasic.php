<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\OptionsToArray;
use Zrcms\Content\Model\Properties;
use Zrcms\Content\Model\PropertiesCmsResourcePublishHistory;
use Zrcms\Content\Model\Trackable;
use Zrcms\Content\Model\TrackableProperties;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourcePublishHistoryToArrayBasic implements CmsResourcePublishHistoryToArray
{
    /**
     * @param CmsResourcePublishHistory $cmsResourcePublishHistory
     * @param array                     $options
     *
     * @return array
     */
    public function __invoke(
        CmsResourcePublishHistory $cmsResourcePublishHistory,
        array $options = []
    ): array
    {
        $dateFormat = Param::get(
            $options,
            OptionsToArray::CREATED_DATE_FORMAT,
            Trackable::DATE_FORMAT
        );

        return [
            PropertiesCmsResourcePublishHistory::ID
            => $cmsResourcePublishHistory->getId(),

            PropertiesCmsResourcePublishHistory::CONTENT_VERSION_ID
            => $cmsResourcePublishHistory->getContentVersionId(),

            PropertiesCmsResourcePublishHistory::ACTION
            => $cmsResourcePublishHistory->getAction(),

            Properties::NAME_PROPERTIES
            => $cmsResourcePublishHistory->getProperties(),

            TrackableProperties::CREATED_BY_USER_ID
            => $cmsResourcePublishHistory->getCreatedByUserId(),

            TrackableProperties::CREATED_REASON
            => $cmsResourcePublishHistory->getCreatedReason(),

            TrackableProperties::CREATED_DATE
            => $cmsResourcePublishHistory->getCreatedDate(),
        ];
    }
}
