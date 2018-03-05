<?php

namespace Zrcms\CoreSite\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertSiteCmsResource extends UpsertCmsResource
{
    /**
     * @param null|string $id
     * @param bool        $published
     * @param string      $contentVersionId
     * @param string      $modifiedByUserId
     * @param string      $modifiedReason
     * @param null|string $modifiedDate
     *
     * @return SiteCmsResource|CmsResource
     * @throws CmsResourceNotExists
     * @throws ContentVersionNotExists
     */
    public function __invoke(
        $id,
        bool $published,
        string $contentVersionId,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ): CmsResource;
}
