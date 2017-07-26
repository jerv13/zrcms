<?php

namespace Zrcms\ContentCountry\Api\Action;

use Zrcms\Content\Api\Action\PublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCountry\Model\CountryCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishCountryCmsResource extends PublishCmsResource
{
    /**
     * @param CountryCmsResource|CmsResource $countryCmsResource
     * @param string                         $publishedByUserId
     * @param string                         $publishReason
     *
     * @return CountryCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $countryCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource;
}
