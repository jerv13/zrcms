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
    const OPTION_ADDITIONAL_PROPERTIES = 'additional-properties';
    const OPTION_PUBLISHED_ONLY = 'published-only';

    const DEFAULT_PUBLISHED_ONLY = true;

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
