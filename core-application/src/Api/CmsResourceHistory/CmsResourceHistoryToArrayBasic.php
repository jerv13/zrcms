<?php

namespace Zrcms\CoreApplication\Api\CmsResourceHistory;

use Reliv\ArrayProperties\Property;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Model\CmsResourceHistory;
use Zrcms\CoreApplication\Api\RemoveProperties;

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
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __invoke(
        CmsResourceHistory $cmsResourceHistory,
        array $options = []
    ): array {
        $array = [];

        $array['id'] = $cmsResourceHistory->getId();

        $array['action'] = $cmsResourceHistory->getAction();

        $array['cmsResourceId'] = $cmsResourceHistory->getCmsResourceId();

        $array['cmsResource'] = $this->cmsResourceToArray->__invoke(
            $cmsResourceHistory->getCmsResource()
        );

        $array['cmsResourceId'] = $cmsResourceHistory->getContentVersionId();

        $array['cmsResource'] = $this->contentVersionToArray->__invoke(
            $cmsResourceHistory->getContentVersion()
        );

        $array['createdByUserId'] = $cmsResourceHistory->getCreatedByUserId();

        $array['createdReason'] = $cmsResourceHistory->getCreatedReason();

        $array['createdDate'] = $cmsResourceHistory->getCreatedDate();

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
