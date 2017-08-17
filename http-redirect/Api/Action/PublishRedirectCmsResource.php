<?php

namespace Zrcms\HttpRedirect\Redirect\Api\Action;

use Zrcms\Content\Api\Action\PublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\HttpRedirect\Redirect\Model\RedirectCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishRedirectCmsResource extends PublishCmsResource
{
    /**
     * @param RedirectCmsResource|CmsResource $RedirectCmsResource
     * @param string                      $publishedByUserId
     * @param string                      $publishReason
     *
     * @return RedirectCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $RedirectCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource;
}
