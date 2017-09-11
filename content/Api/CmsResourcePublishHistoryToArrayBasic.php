<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\Properties;
use Zrcms\Content\Model\PropertiesCmsResourcePublishHistory;
use Zrcms\Content\Model\TrackableProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourcePublishHistoryToArrayBasic implements CmsResourcePublishHistoryToArray
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
        return [
            PropertiesCmsResourcePublishHistory::ID
            => $cmsResourcePublishHistory->getId(),

            PropertiesCmsResourcePublishHistory::CONTENT_VERSION
            => $this->contentVersionToArray->__invoke(
                $cmsResourcePublishHistory->getContentVersion()
            ),

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
