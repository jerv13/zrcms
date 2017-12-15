<?php

namespace Zrcms\Acl\Api;

use Psr\Http\Message\ServerRequestInterface;
use RcmUser\Api\Authentication\HasIdentity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedRcmUserLoggedIn implements IsAllowed
{
    protected $hasIdentity;

    /**
     * @param HasIdentity $hasIdentity
     */
    public function __construct(
       HasIdentity $hasIdentity
    ) {
        $this->hasIdentity = $hasIdentity;
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
        return $this->hasIdentity->__invoke(
            $request
        );
    }
}
