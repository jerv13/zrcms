<?php

namespace Zrcms\Core\Block\Api\Repository;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Block\Model\BlockRevision;

/**
 * DataProvider interface
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface GetBlockRevisionData
{
    /**
     * Blocks automatically get their instance configs when rendering. A data service like this
     * is used to return any custom data in addition to the instance config to the plugin
     * template for rendering.
     *
     * @param BlockRevision  $blockRevision
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        BlockRevision $blockRevision,
        ServerRequestInterface $request,
        array $options = []
    ) : array;
}
