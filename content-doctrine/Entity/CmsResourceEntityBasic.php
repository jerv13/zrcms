<?php

namespace Zrcms\ContentDoctrine\Entity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceEntityBasic extends CmsResourceEntityAbstract implements CmsResourceEntity
{
    /**
     * @param string|null   $id
     * @param bool          $published
     * @param ContentEntity $contentVersion
     * @param string        $createdByUserId
     * @param string        $createdReason
     * @param string|null   $createdDate
     */
    public function __construct(
        $id,
        bool $published,
        ContentEntity $contentVersion,
        string $createdByUserId,
        string $createdReason,
        string $createdDate = null
    ) {
        parent::__construct(
            $id,
            $published,
            $contentVersion,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }
}
