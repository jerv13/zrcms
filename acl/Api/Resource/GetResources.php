<?php

namespace Zrcms\Acl\Api\Resources;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetResources
{
    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
