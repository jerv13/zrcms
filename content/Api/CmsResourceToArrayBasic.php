<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\OptionsToArray;
use Zrcms\Content\Model\Properties;
use Zrcms\Content\Model\PropertiesCmsResource;
use Zrcms\Content\Model\Trackable;
use Zrcms\Content\Model\TrackableProperties;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceToArrayBasic implements CmsResourceToArray
{
    /**
     * @param CmsResource $cmsResource
     * @param array       $options
     *
     * @return array
     */
    public function __invoke(
        CmsResource $cmsResource,
        array $options = []
    ): array
    {
        $dateFormat = Param::get(
            $options,
            OptionsToArray::CREATED_DATE_FORMAT,
            Trackable::DATE_FORMAT
        );

        return [
            PropertiesCmsResource::ID
            => $cmsResource->getId(),

            PropertiesCmsResource::CONTENT_VERSION_ID
            => $cmsResource->getContentVersionId(),

            PropertiesCmsResource::PUBLISHED
            => $cmsResource->isPublished(),

            Properties::NAME_PROPERTIES
            => $cmsResource->getProperties(),

            TrackableProperties::CREATED_BY_USER_ID
            => $cmsResource->getCreatedByUserId(),

            TrackableProperties::CREATED_REASON
            => $cmsResource->getCreatedReason(),

            TrackableProperties::CREATED_DATE
            => $cmsResource->getCreatedDate(),
        ];
    }
}
