<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Exception\InvalidGetViewByRequest;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetViewByRequest
{
    const OPTION_DETERMINE_VIEW_STRATEGY_OPTIONS = 'determine-view-strategy-options';
    const OPTION_BUILD_REQUESTED_VIEW_OPTIONS = 'build-requested-view-options';
    const OPTION_MUTATE_VIEW_OPTIONS = 'mutate-view-options';

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws ViewDataNotFound|InvalidGetViewByRequest
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): View;
}
