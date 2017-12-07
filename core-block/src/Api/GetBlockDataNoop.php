<?php

namespace Zrcms\CoreBlock\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreBlock\Model\Block;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockDataNoop implements GetBlockData
{
    /**
     * @param Block                  $block
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        Block $block,
        ServerRequestInterface $request,
        array $options = []
    ) : array
    {
        return [];
    }
}
