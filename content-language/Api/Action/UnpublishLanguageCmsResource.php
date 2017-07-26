<?php

namespace Zrcms\ContentLanguage\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentLanguage\Model\LanguageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishLanguageCmsResource extends UnpublishCmsResource
{
    /**
     * @param LanguageCmsResource|CmsResource $languageCmsResource
     * @param string                      $unpublishedByUserId
     * @param string                      $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $languageCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
