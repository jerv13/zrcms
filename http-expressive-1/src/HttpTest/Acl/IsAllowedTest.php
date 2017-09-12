<?php

namespace Zrcms\HttpExpressive1\HttpTest\Acl;

use Zrcms\Acl\Api\IsAllowed;
use Zrcms\HttpExpressive1\HttpAcl\IsAllowedCheckApi;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedTest extends IsAllowedCheckApi
{
    /**
     * @param HandleResponseApi $handleResponse
     * @param IsAllowed         $isAllowed
     * @param array             $aclOptions
     */
    public function __construct(
        HandleResponseApi $handleResponse,
        IsAllowed $isAllowed,
        array $aclOptions
    ) {
        parent::__construct(
            $handleResponse,
            $isAllowed,
            $aclOptions,
            'is-allowed-test'
        );
    }
}
