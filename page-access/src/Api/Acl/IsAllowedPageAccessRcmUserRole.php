<?php

namespace Zrcms\PageAccess\Api\Acl;

use Psr\Http\Message\ServerRequestInterface;
use RcmUser\Api\Acl\HasRoleBasedAccess;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedPageAccessRcmUserRole implements IsAllowedPageAccess
{
    const OPTION_ALLOWED_ROLES = 'allowed-roles';

    protected $hasRoleBasedAccess;

    /**
     * @param HasRoleBasedAccess $hasRoleBasedAccess
     */
    public function __construct(
        HasRoleBasedAccess $hasRoleBasedAccess
    ) {
        $this->hasRoleBasedAccess = $hasRoleBasedAccess;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $pageAccessOptions
     *
     * @return bool
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $pageAccessOptions = []
    ): bool {
        $roles = Property::getArray(
            $pageAccessOptions,
            static::OPTION_ALLOWED_ROLES,
            []
        );

        // NOTE: if no roles are defined, we allow access
        if (empty($roles)) {
            return true;
        }

        foreach ($roles as $roleId) {
            $hasRole = $this->hasRoleBasedAccess->__invoke(
                $request,
                $roleId
            );

            // NOTE: If user has any role, then he has access
            if ($hasRole) {
                return true;
            }
        }

        return false;
    }
}
