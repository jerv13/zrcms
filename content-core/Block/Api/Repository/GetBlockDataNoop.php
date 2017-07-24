<?php

namespace Zrcms\ContentCore\Block\Api\Repository;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\Block\Model\Block;

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
