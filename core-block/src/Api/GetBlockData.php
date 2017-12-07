<?php

namespace Zrcms\CoreBlock\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreBlock\Model\Block;

/**
 * DataProvider interface
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface GetBlockData
{
    /**
     * Blocks automatically get their instance configs when rendering. A data service like this
     * is used to return any custom data in addition to the instance config to the plugin
     * template for rendering.
     *
     * @param Block  $block
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        Block $block,
        ServerRequestInterface $request,
        array $options = []
    ) : array;
}
