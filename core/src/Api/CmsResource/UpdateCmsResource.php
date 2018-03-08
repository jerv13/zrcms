<?php

namespace Zrcms\Core\Api\CmsResource;

use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Model\CmsResource;

/**
 * @todo Replace UpsertCmsResource
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface UpdateCmsResource
{
    /**
     * @param string|null $id
     * @param bool        $published
     * @param string      $contentVersionId
     * @param string      $modifiedByUserId
     * @param string      $modifiedReason
     * @param string|null $modifiedDate
     *
     * @return CmsResource
     * @throws CmsResourceNotExists
     */
    public function __invoke(
        string $id,
        bool $published,
        string $contentVersionId,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ):CmsResource;
}
