<?php

namespace Zrcms\Core\View\Api\Repository;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindViewByRequest
{
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): View;
}
