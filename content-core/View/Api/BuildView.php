<?php

namespace Zrcms\ContentCore\View\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\View\Model\View;

/**
 * @todo   This may NOT be needed, attributes can be passed in request
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildView
{
    /**
     * @param ServerRequestInterface $request
     * @param View                   $view
     * @param array                  $options
     *
     * @return View
     */
    public function __invoke(
        ServerRequestInterface $request,
        View $view,
        array $options = []
    ): View;
}
