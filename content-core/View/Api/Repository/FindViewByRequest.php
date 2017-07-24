<?php

namespace Zrcms\ContentCore\View\Api\Repository;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\View\Model\View;

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
