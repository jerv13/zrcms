<?php

namespace Zrcms\Core\BlockInstance\Api;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetBlockInstancesWithData
{
    /**
     * @param array                  $blockInstances [BlockInstance]
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array [BlockInstanceData]
     */
    public function __invoke(
        array $blockInstances,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
