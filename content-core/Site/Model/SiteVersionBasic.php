<?php

namespace Zrcms\ContentCore\Site\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SiteVersionBasic extends SiteVersionAbstract implements SiteVersion
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
