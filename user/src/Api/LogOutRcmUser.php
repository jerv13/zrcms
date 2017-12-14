<?php

namespace Zrcms\User\Api;

use Psr\Http\Message\ServerRequestInterface;
use RcmUser\Service\RcmUserService;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LogOutRcmUser implements LogOut
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
     * @param array                  $options
     *
     * @return bool
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): bool {
        $this->rcmUserService->clearIdentity();
        // @todo BC
        session_destroy();

        return true;
    }
}
