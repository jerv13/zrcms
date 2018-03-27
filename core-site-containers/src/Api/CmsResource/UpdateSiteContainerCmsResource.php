<?php

namespace Zrcms\CoreSiteContainer\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\UpdateCmsResource;
use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreSiteContainer\Model\SiteContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpdateSiteContainerCmsResource extends UpdateCmsResource
{
    /**
     * @param null|string $id
     * @param bool        $published
     * @param string      $contentVersionId
     * @param string      $modifiedByUserId
     * @param string      $modifiedReason
     * @param null|string $modifiedDate
     *
     * @return SiteContainerCmsResource|CmsResource
     * @throws CmsResourceNotExists
     * @throws ContentVersionNotExists
     */
    public function __invoke(
        string $id,
        bool $published,
        string $contentVersionId,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ): CmsResource;
}
