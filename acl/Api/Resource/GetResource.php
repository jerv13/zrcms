<?php

namespace Zrcms\Acl\Api\Resources;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetResource
{

    /**
     * @param ServerRequestInterface $request
     * @param string                 $resourceId
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $resourceId,
        array $options = []
    ): array;
}
