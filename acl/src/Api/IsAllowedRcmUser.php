<?php

namespace Zrcms\Acl\Api;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedRcmUser implements IsAllowed
{
    const OPTION_RESOURCE_ID = 'resourceId';
    const OPTION_PRIVILEGE = 'privilege';

    protected $isAllowed;

    /**
     * @param \RcmUser\Api\Acl\IsAllowed $isAllowed
     */
    public function __construct(
        \RcmUser\Api\Acl\IsAllowed $isAllowed
    ) {
        $this->isAllowed = $isAllowed;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return bool
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyMissing
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): bool {
        $resourceId = Property::getRequired(
            $options,
            self::OPTION_RESOURCE_ID
        );

        $privilege = Property::get(
            $options,
            self::OPTION_PRIVILEGE,
            null
        );

        return $this->isAllowed->__invoke(
            $request,
            $resourceId,
            $privilege
        );
    }
}
