<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourcePublishHistoryBasic extends CmsResourcePublishHistoryAbstract implements CmsResourcePublishHistory
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
            $publishReason
        );
    }
}
