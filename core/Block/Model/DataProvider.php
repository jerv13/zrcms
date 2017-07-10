<?php

namespace Zrcms\Core\Block\Model;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\BlockInstance\Model\BlockInstance;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface DataProvider
{
    /**
     * Blocks automatically get their instance configs when rendering. A data service like this
     * is used to return any custom data in addition to the instance config to the plugin
     * template for rendering.
     *
     * @param BlockInstance          $instance
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    public function __invoke(
        BlockInstance $instance,
        ServerRequestInterface $request
    ) : array;
}
