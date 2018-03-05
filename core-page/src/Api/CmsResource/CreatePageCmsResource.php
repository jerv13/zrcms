<?php

namespace Zrcms\CorePage\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\CreateCmsResource;
use Zrcms\Core\Exception\CmsResourceExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CorePage\Model\PageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CreatePageCmsResource extends CreateCmsResource
{
    /**
     * @param string|null $id
     * @param bool        $published
     * @param string      $contentVersionId
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     *
     * @return PageCmsResource|CmsResource
     * @throws CmsResourceExists
     * @throws ContentVersionNotExists
     */
    public function __invoke(
        $id,
        bool $published,
        string $contentVersionId,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ): CmsResource;
}
