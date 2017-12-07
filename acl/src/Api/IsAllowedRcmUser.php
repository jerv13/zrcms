<?php

namespace Zrcms\Acl\Api;

use Psr\Http\Message\ServerRequestInterface;
use RcmUser\Service\RcmUserService;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedRcmUser implements IsAllowed
{
    const OPTION_RESOURCE_ID = 'resourceId';
    const OPTION_PRIVILEGE = 'privilege';

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
     * @param array                  $options
     *
     * @return bool
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): bool
    {
        $resourceId = Param::getRequired(
            $options,
            self::OPTION_RESOURCE_ID
        );

        $privilege = Param::get(
            $options,
            self::OPTION_PRIVILEGE,
            null
        );

        // @todo This locks up due to issue in RCM user
        // @todo issue with RcmUser\Acl\Service\AuthorizeService (416) $this->getEventManager()->trigger(
        // @todo This should utilize the request
        return $this->rcmUserService->isAllowed(
            $resourceId,
            $privilege
        );
    }
}
