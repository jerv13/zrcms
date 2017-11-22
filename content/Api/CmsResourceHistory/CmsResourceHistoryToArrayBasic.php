<?php

namespace Zrcms\Content\Api\CmsResourceHistory;

use Zrcms\Content\Api\CmsResource\CmsResourceToArray;
use Zrcms\Content\Api\Content\ContentVersionToArray;
use Zrcms\Content\Model\CmsResourceHistory;
use Zrcms\Content\Model\TrackableProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceHistoryToArrayBasic implements CmsResourceHistoryToArray
{
    /**
     * @var ContentVersionToArray
     */
    protected $contentVersionToArray;

    /**
     * @var CmsResourceToArray
     */
    protected $cmsResourceToArray;

    /**
     * @param ContentVersionToArray $contentVersionToArray
     * @param CmsResourceToArray    $cmsResourceToArray
     */
    public function __construct(
        ContentVersionToArray $contentVersionToArray,
        CmsResourceToArray $cmsResourceToArray
    ) {
        $this->contentVersionToArray = $contentVersionToArray;
        $this->cmsResourceToArray = $cmsResourceToArray;
    }

    /**
     * @param CmsResourceHistory $cmsResourceHistory
     * @param array              $options
     *
     * @return array
     */
    public function __invoke(
        CmsResourceHistory $cmsResourceHistory,
        array $options = []
    ): array {
        $contentVersionArray = $this->contentVersionToArray->__invoke(
            $cmsResourceHistory->getContentVersion()
        );

        $cmsResourceArray = $this->cmsResourceToArray->__invoke(
            $cmsResourceHistory->getCmsResource()
        );

        return [
            'id'
            => $cmsResourceHistory->getId(),

            'action'
            => $cmsResourceHistory->getAction(),

            'cmsResourceId'
            => $cmsResourceHistory->getCmsResourceId(),

            'cmsResource'
            => $cmsResourceArray,

            'contentVersionId'
            => $cmsResourceHistory->getContentVersionId(),

            'contentVersion'
            => $contentVersionArray,

            TrackableProperties::CREATED_BY_USER_ID
            => $cmsResourceHistory->getCreatedByUserId(),

            TrackableProperties::CREATED_REASON
            => $cmsResourceHistory->getCreatedReason(),

            TrackableProperties::CREATED_DATE
            => $cmsResourceHistory->getCreatedDate(),
        ];
    }
}
