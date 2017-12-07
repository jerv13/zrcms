<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetViewByRequest
{
    const OPTION_ADDITIONAL_PROPERTIES = 'additionalProperties';

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): View;
}
