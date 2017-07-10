<?php

namespace Zrcms\Core\Container\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Zrcms\Core\BlockInstance\Model\BlockInstanceData;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetBlockInstanceWithData
{
    /**
     * @param BlockInstance          $blockInstance
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return BlockInstanceData
     */
    public function __invoke(
        BlockInstance $blockInstance,
        ServerRequestInterface $request,
        array $options = []
    ): BlockInstanceData;
}
