<?php

namespace Zrcms\ContentCountry\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCountry\Model\CountryCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishCountryCmsResource extends UnpublishCmsResource
{
    /**
     * @param CountryCmsResource|CmsResource $countryCmsResource
     * @param string                      $unpublishedByUserId
     * @param string                      $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $countryCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
