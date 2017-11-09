<?php

namespace Zrcms\ContentRedirect\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RedirectVersionBasic extends RedirectVersionAbstract implements RedirectVersion
{
    /**
     * @param string|null $id
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
        string $createdDate = null
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
