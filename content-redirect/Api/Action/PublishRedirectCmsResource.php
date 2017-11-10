<?php

namespace Zrcms\ContentRedirect\Api\Action;

use Zrcms\Content\Api\Action\PublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishRedirectCmsResource extends PublishCmsResource
{
    /**
     * @param RedirectCmsResource|CmsResource $RedirectCmsResource
     * @param string                      $publishedByUserId
     * @param string                      $publishReason
     * @param string|null $publishDate
     *
     * @return RedirectCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $RedirectCmsResource,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource;
}
