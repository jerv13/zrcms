<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\CmsResourcePublishHistory;
use Zrcms\Content\Model\Properties;
use Zrcms\Content\Fields\FieldsCmsResourcePublishHistory;
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
        $contentVersionArray = $this->contentVersionToArray->__invoke(
            $cmsResourcePublishHistory->getContentVersion()
        );

        $cmsResourceArray = $this->cmsResourceToArray->__invoke(
            $cmsResourcePublishHistory->getCmsResource()
        );

        return [
            'id'
            => $cmsResourcePublishHistory->getId(),

            'action'
            => $cmsResourcePublishHistory->getAction(),

            'cmsResource'
            => $cmsResourceArray,

            'cmsResourceProperties'
            => $cmsResourcePublishHistory->getCmsResourceProperties(),

            'contentVersion'
            => $contentVersionArray,

            TrackableProperties::CREATED_BY_USER_ID
            => $cmsResourcePublishHistory->getCreatedByUserId(),

            TrackableProperties::CREATED_REASON
            => $cmsResourcePublishHistory->getCreatedReason(),

            TrackableProperties::CREATED_DATE
            => $cmsResourcePublishHistory->getCreatedDate(),
        ];
    }
}
