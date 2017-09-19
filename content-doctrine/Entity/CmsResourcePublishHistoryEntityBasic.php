<?php

namespace Zrcms\ContentDoctrine\Entity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourcePublishHistoryEntityBasic
    extends CmsResourcePublishHistoryEntityAbstract
    implements CmsResourcePublishHistoryEntity
{
    /**
     * @param null|string       $id
     * @param string            $action
     * @param CmsResourceEntity $cmsResourceEntity
     * @param string            $publishedByUserId
     * @param string            $publishReason
     */
    public function __construct(
        $id,
        string $action,
        CmsResourceEntity $cmsResourceEntity,
        string $publishedByUserId,
        string $publishReason
    ) {
        parent::__construct(
            $id,
            $action,
            $cmsResourceEntity,
            $publishedByUserId,
            $publishReason
        );
    }
}
