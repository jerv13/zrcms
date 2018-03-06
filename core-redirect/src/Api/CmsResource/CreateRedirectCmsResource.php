<?php

namespace Zrcms\CoreRedirect\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\CreateCmsResource;
use Zrcms\Core\Exception\CmsResourceExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreRedirect\Model\RedirectCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CreateRedirectCmsResource extends CreateCmsResource
{
    /**
     * @param string|null $id
     * @param bool        $published
     * @param string      $contentVersionId
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     *
     * @return RedirectCmsResource|CmsResource
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
