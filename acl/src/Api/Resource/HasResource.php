<?php

namespace Zrcms\Acl\Api\Resources;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface HasResource
{
    /**
     * @param ServerRequestInterface $request
     * @param string                 $resourceId
     * @param array                  $options
     *
     * @return bool
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $resourceId,
        array $options = []
    ): bool;
}
