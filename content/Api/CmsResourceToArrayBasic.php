<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\Properties;
use Zrcms\Content\Model\PropertiesCmsResource;
use Zrcms\Content\Model\TrackableProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceToArrayBasic implements CmsResourceToArray
{
    /**
     * @var ContentVersionToArray
     */
    protected $contentVersionToArray;

    /**
     * @param ContentVersionToArray $contentVersionToArray
     */
    public function __construct(
        ContentVersionToArray $contentVersionToArray
    ) {
        $this->contentVersionToArray = $contentVersionToArray;
    }

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
        return [
            PropertiesCmsResource::ID
            => $cmsResource->getId(),

            PropertiesCmsResource::CONTENT_VERSION
            => $this->contentVersionToArray->__invoke(
                $cmsResource->getContentVersion()
            ),

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
