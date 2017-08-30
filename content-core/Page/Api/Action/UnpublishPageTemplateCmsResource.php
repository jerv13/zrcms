<?php

namespace Zrcms\ContentCore\Page\Api\Action;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishPageTemplateCmsResource extends UnpublishPageContainerCmsResource
{
    /**
     * @param string $pageTemplateCmsResourceId
     * @param string $unpublishedByUserId
     * @param string $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        string $pageTemplateCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
