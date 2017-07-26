<?php

namespace Zrcms\ContentLanguage\Api\Action;

use Zrcms\Content\Api\Action\PublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentLanguage\Model\LanguageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishLanguageCmsResource extends PublishCmsResource
{
    /**
     * @param LanguageCmsResource|CmsResource $languageCmsResource
     * @param string                         $publishedByUserId
     * @param string                         $publishReason
     *
     * @return LanguageCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $languageCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource;
}
