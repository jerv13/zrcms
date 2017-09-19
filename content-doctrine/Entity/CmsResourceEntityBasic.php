<?php

namespace Zrcms\ContentDoctrine\Entity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CmsResourceEntityBasic extends CmsResourceEntityAbstract implements CmsResourceEntity
{
    /**
     * @param int|null      $id
     * @param bool          $published
     * @param ContentEntity $contentEntity
     * @param array         $properties
     * @param string        $createdByUserId
     * @param string        $createdReason
     */
    public function __construct(
        $id,
        bool $published,
        ContentEntity $contentEntity,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        parent::__construct(
            $id,
            $published,
            $contentEntity,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
}
