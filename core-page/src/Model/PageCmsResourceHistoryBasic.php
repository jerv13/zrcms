<?php

namespace Zrcms\CorePage\Model;

use Zrcms\Core\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PageCmsResourceHistoryBasic extends PageCmsResourceHistoryAbstract implements PageCmsResourceHistory
{
    /**
     * @param string|null                 $id
     * @param string                      $action
     * @param PageCmsResource|CmsResource $cmsResource
     * @param string                      $publishedByUserId
     * @param string                      $publishReason
     * @param string|null                 $publishDate
     *
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __construct(
        $id,
        string $action,
        CmsResource $cmsResource,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ) {
        parent::__construct(
            $id,
            $action,
            $cmsResource,
            $publishedByUserId,
            $publishReason,
            $publishDate
        );
    }
}
