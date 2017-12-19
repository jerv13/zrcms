<?php

namespace Zrcms\Acl\Api;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedRcmUserSitesAdmin implements IsAllowed
{
    protected $isAllowed;

    /**
     * @param IsAllowedRcmUser $isAllowed
     */
    public function __construct(
        IsAllowedRcmUser $isAllowed
    ) {
        $this->isAllowed = $isAllowed;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return bool
     * @throws \Exception
     * @throws \Zrcms\Param\Exception\ParamMissing
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): bool {
        return $this->isAllowed->__invoke(
            $request,
            [
                IsAllowedRcmUser::OPTION_RESOURCE_ID => 'sites',
                IsAllowedRcmUser::OPTION_PRIVILEGE => 'admin',
            ]
        );
    }
}
