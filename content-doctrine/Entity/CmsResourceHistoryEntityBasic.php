<?php

namespace Zrcms\ContentDoctrine\Entity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceHistoryEntityBasic
    extends CmsResourceHistoryEntityAbstract
    implements CmsResourceHistoryEntity
{
    /**
     * @param string|null       $id
     * @param string            $action
     * @param CmsResourceEntity $cmsResourceEntity
     * @param string            $publishedByUserId
     * @param string            $publishReason
     * @param string|null       $publishDate
     */
    public function __construct(
        $id,
        string $action,
        CmsResourceEntity $cmsResourceEntity,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ) {
        parent::__construct(
            $id,
            $action,
            $cmsResourceEntity,
            $publishedByUserId,
            $publishReason,
            $publishDate
        );
    }
}
