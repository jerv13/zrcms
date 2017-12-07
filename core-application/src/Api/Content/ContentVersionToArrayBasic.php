<?php

namespace Zrcms\CoreApplication\Api\Content;

use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\Core\Model\TrackableProperties;

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
    ): array {
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
