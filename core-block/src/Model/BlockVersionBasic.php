<?php

namespace Zrcms\CoreBlock\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BlockVersionBasic extends BlockVersionAbstract implements BlockVersion
{
    /**
     * @param null|string $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }
}
