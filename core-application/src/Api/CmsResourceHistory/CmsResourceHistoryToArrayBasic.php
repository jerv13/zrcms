<?php

namespace Zrcms\CoreApplication\Api\CmsResourceHistory;

use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResourceHistory\CmsResourceHistoryToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Model\CmsResourceHistory;
use Zrcms\CoreApplication\Api\RemoveProperties;
use Zrcms\Param\Param;

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

        $array['cmsResource'] = $this->cmsResourceToArray->__invoke(
            $cmsResourceHistory->getCmsResource()
        );

        $array['createdByUserId'] = $cmsResourceHistory->getCreatedByUserId();

        $array['createdReason'] = $cmsResourceHistory->getCreatedReason();

        $array['createdDate'] = $cmsResourceHistory->getCreatedDate();

        return RemoveProperties::invoke(
            $array,
            Param::getArray(
                $options,
                self::OPTION_HIDE_PROPERTIES,
                []
            )
        );
    }
}
