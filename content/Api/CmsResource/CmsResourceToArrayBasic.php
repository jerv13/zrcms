<?php

namespace Zrcms\Content\Api\CmsResource;

use Zrcms\Content\Api\Content\ContentVersionToArray;
use Zrcms\Content\Model\CmsResource;
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
    ): array {
        $contentVersion = $this->contentVersionToArray->__invoke(
            $cmsResource->getContentVersion()
        );

        return [
            'id'
            => $cmsResource->getId(),

            'contentVersionId'
            => $cmsResource->getContentVersionId(),

            'contentVersion'
            => $contentVersion,

            'published'
            => $cmsResource->isPublished(),

            TrackableProperties::CREATED_BY_USER_ID
            => $cmsResource->getCreatedByUserId(),

            TrackableProperties::CREATED_REASON
            => $cmsResource->getCreatedReason(),

            TrackableProperties::CREATED_DATE
            => $cmsResource->getCreatedDate(),
        ];
    }
}
