<?php

namespace Zrcms\Core\BlockInstance\Api\Repository;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\BlockInstance\Model\BlockInstance;

/**
 * DataProvider interface
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface GetBlockInstanceData
{
    /**
     * Blocks automatically get their instance configs when rendering. A data service like this
     * is used to return any custom data in addition to the instance config to the plugin
     * template for rendering.
     *
     * @param BlockInstance          $blockInstance
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        BlockInstance $blockInstance,
        ServerRequestInterface $request,
        array $options = []
    ) : array;
}
