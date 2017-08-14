<?php

namespace Zrcms\Acl\Api;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface IsAllowed
{
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
    ): bool;
}
