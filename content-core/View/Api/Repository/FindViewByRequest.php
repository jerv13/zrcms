<?php

namespace Zrcms\ContentCore\View\Api\Repository;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindViewByRequest
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
