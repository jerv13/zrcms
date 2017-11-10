<?php

namespace Zrcms\ContentRedirect\Model;

use Zrcms\Content\Exception\CmsResourceInvalid;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourceHistoryAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class RedirectCmsResourceHistoryAbstract extends CmsResourceHistoryAbstract
{
    /**
     * @param null|string $id
     * @param string      $action
     * @param RedirectCmsResource|CmsResource $cmsResource
     * @param string      $publishedByUserId
     * @param string      $publishReason
     * @param string|null $publishDate
     */
    public function __construct(
        $id,
        string $action,
        CmsResource $cmsResource,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ) {
        parent::__construct(
            $id,
            $action,
            $cmsResource,
            $publishedByUserId,
            $publishedByUserId,
            $publishDate
        );
    }

    /**
     * @param CmsResource $cmsResource
     *
     * @return void
     * @throws CmsResourceInvalid
     */
    protected function assertValidCmsResource($cmsResource)
    {
        if (!$cmsResource instanceof RedirectCmsResource) {
            throw new CmsResourceInvalid(
                'CmsResource must be instance of: ' . RedirectCmsResource::class
                . ' got: ' . var_export($cmsResource, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
