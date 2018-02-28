<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Model\ViewStrategyResult;
use Zrcms\CoreView\Model\ViewStrategyResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DetermineViewStrategyDefault implements DetermineViewStrategy
{
    const STRATEGY = 'default';

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return ViewStrategyResult
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): ViewStrategyResult {
        // Always do default
        return new ViewStrategyResultBasic(
            self::STRATEGY,
            ViewStrategyResult::OK_STATUS
        );
    }
}
