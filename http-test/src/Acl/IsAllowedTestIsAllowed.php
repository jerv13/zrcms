<?php

namespace Zrcms\HttpTest\Acl;

use Zrcms\Acl\Api\IsAllowed;
use Zrcms\HttpApi\Acl\HttpApiIsAllowed;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedTestIsAllowed extends HttpApiIsAllowed
{
    /**
     * @param IsAllowed $isAllowed
     * @param array     $aclOptions
     */
    public function __construct(
        IsAllowed $isAllowed,
        array $aclOptions
    ) {
        parent::__construct(
            $isAllowed,
            $aclOptions,
            'is-allowed-test'
        );
    }
}
