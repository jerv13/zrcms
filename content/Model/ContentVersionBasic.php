<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ContentVersionBasic extends ContentVersionAbstract implements ContentVersion
{
    /**
     * @param string|null $id
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
