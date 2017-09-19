<?php

namespace Zrcms\ContentDoctrine\Entity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentEntityBasic extends ContentEntityAbstract implements ContentEntity
{
    /**
     * @param null|string $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
}
