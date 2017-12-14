<?php

namespace Zrcms\CorePage\Model;

use Zrcms\Core\Exception\CmsResourceInvalid;
use Zrcms\Core\Model\CmsResource;
use Zrcms\Core\Model\CmsResourceHistoryAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageDraftCmsResourceHistoryAbstract extends CmsResourceHistoryAbstract
{
    /**
     * @param             $id
     * @param string      $action
     * @param CmsResource $cmsResource
     * @param string      $publishedByUserId
     * @param string      $publishReason
     * @param null        $publishDate
     *
     * @throws \Zrcms\Core\Exception\TrackingInvalid
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
            $publishReason,
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
        if (!$cmsResource instanceof PageDraftCmsResource) {
            throw new CmsResourceInvalid(
                'CmsResource must be instance of: ' . PageDraftCmsResource::class
                . ' got: ' . var_export($cmsResource, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
