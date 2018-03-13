<?php

namespace Zrcms\CoreApplication\Api\CmsResource;

use Reliv\ArrayProperties\Property;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreApplication\Api\RemoveProperties;

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
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __invoke(
        CmsResource $cmsResource,
        array $options = []
    ): array {
        $array = [];
        $array['id'] = $cmsResource->getId();
        $array['published'] = $cmsResource->isPublished();
        $array['contentVersionId'] = $cmsResource->getContentVersionId();
        $array['contentVersion'] = $this->contentVersionToArray->__invoke(
            $cmsResource->getContentVersion(),
            $options
        );

        $array['createdByUserId'] = $cmsResource->getCreatedByUserId();

        $array['createdReason'] = $cmsResource->getCreatedReason();

        $array['createdDate'] = $cmsResource->getCreatedDate();

        $array['modifiedByUserId'] = $cmsResource->getModifiedByUserId();

        $array['modifiedReason'] = $cmsResource->getModifiedReason();

        $array['modifiedDate'] = $cmsResource->getModifiedDate();

        return RemoveProperties::invoke(
            $array,
            Property::getArray(
                $options,
                self::OPTION_HIDE_PROPERTIES,
                []
            )
        );
    }
}
