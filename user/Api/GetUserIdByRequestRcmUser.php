<?php

namespace Zrcms\User\Api;

use Psr\Http\Message\ServerRequestInterface;
use RcmUser\Service\RcmUserService;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetUserIdByRequestRcmUser implements GetUserIdByRequest
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
     * @return string
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): string
    {
        // @todo User the request to get this user

        $user = $this->rcmUserService->getCurrentUser();

        if (empty($user)) {
            return '';
        }

        return (string)$user->getId();
    }
}
