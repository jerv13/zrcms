<?php

namespace Zrcms\Core\Layout\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetLayoutRenderData
{
    /**
     * @param Layout                 $layout
     * @param Page                   $page
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        Layout $layout,
        Page $page,
        ServerRequestInterface $request,
        array $options = []
    ): array;
}
