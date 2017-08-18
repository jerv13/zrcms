<?php

namespace Zrcms\ContentRedirect\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishRedirectCmsResource extends UnpublishCmsResource
{
    /**
     * @param RedirectCmsResource|CmsResource $RedirectCmsResource
     * @param string                      $unpublishedByUserId
     * @param string                      $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $RedirectCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
