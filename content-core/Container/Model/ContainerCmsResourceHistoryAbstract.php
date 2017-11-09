<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Exception\CmsResourceInvalid;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\CmsResourceHistoryAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerCmsResourceHistoryAbstract extends CmsResourceHistoryAbstract
{
    /**
     * @param string|null $id
     * @param string      $action
     * @param CmsResource $cmsResource
     * @param string      $publishedByUserId
     * @param string      $publishReason
     */
    public function __construct(
        $id,
        string $action,
        CmsResource $cmsResource,
        string $publishedByUserId,
        string $publishReason
    ) {
        parent::__construct(
            $id,
            $action,
            $cmsResource,
            $publishedByUserId,
            $publishedByUserId
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
        if (!$cmsResource instanceof ContainerCmsResource) {
            throw new CmsResourceInvalid(
                'CmsResource must be instance of: ' . ContainerCmsResource::class
                . ' got: ' . var_export($cmsResource, true)
                . ' for: ' . get_class($this)
            );
        }
    }
}
