<?php

namespace Zrcms\CoreRedirect\Model;

use Zrcms\Core\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RedirectCmsResourceHistoryBasic
    extends RedirectCmsResourceHistoryAbstract
    implements RedirectCmsResourceHistory
{
    /**
     * @param null|string                     $id
     * @param string                          $action
     * @param RedirectCmsResource|CmsResource $cmsResource
     * @param string                          $publishedByUserId
     * @param string                          $publishReason
     * @param string|null                     $publishDate
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
