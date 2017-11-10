<?php

namespace Zrcms\ContentCore\Page\Api\Action;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishPageTemplateCmsResource extends UnpublishPageCmsResource
{
    /**
     * @param string      $pageTemplateCmsResourceId
     * @param string      $unpublishedByUserId
     * @param string      $unpublishReason
     * @param string|null $unpublishDate
     *
     * @return bool
     */
    public function __invoke(
        string $pageTemplateCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason,
        $unpublishDate = null
    ): bool;
}
