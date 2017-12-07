<?php

namespace Zrcms\Acl\Api;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\Server\Environment;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedRelivServerEnvironmentNoneProduction implements IsAllowed
{
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
        return !Environment::getInstance()->isProduction();
    }
}
