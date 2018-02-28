<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Exception\BuildRequestedViewStrategyInvalid;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildRequestedView
{
    /**
     * @param ServerRequestInterface $request
     * @param string                 $strategy
     * @param array                  $options
     *
     * @return View
     * @throws BuildRequestedViewStrategyInvalid
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $strategy,
        array $options = []
    ): View;
}
