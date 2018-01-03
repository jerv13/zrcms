<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetViewByRequest
{
    const REQUEST_ATTRIBUTE_GET_VIEW_OPTIONS = 'zrcms-get-view-options';
    const OPTION_ADDITIONAL_PROPERTIES = 'additionalProperties';

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws ViewDataNotFound
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): View;
}
