<?php

namespace Zrcms\Acl\Api;

use Psr\Http\Message\ServerRequestInterface;
use RcmUser\Service\RcmUserService;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedRcmUser implements IsAllowed
{
    /**
     * @var RcmUserService
     */
    protected $rcmUserService;

    /**
     * @param RcmUserService $rcmUserService
     */
    public function __construct(
        RcmUserService $rcmUserService
    ) {
        $this->rcmUserService = $rcmUserService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param string                 $resourceId
     * @param null                   $privilege
     * @param array                  $options
     *
     * @return bool
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $resourceId,
        $privilege = null,
        array $options = []
    ): bool
    {
        // @todo This locks up due to issue in RCM user
        // @todo issue with RcmUser\Acl\Service\AuthorizeService (416) $this->getEventManager()->trigger(
        // @todo This should utilize the request
        return $this->rcmUserService->isAllowed(
            $resourceId,
            $privilege
        );
    }
}
