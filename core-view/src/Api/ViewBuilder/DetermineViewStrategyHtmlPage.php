<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Model\ViewStrategyResult;
use Zrcms\CoreView\Model\ViewStrategyResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DetermineViewStrategyHtmlPage implements DetermineViewStrategy
{
    const STRATEGY = 'html';
    // Use a middleware to set this
    const ATTRIBUTE_VIEW_HTML = BuildViewHtmlPage::ATTRIBUTE_VIEW_HTML;

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
        $html = (bool)$request->getAttribute(
            self::ATTRIBUTE_VIEW_HTML,
            null
        );

        if (empty($html)) {
            return new ViewStrategyResultBasic(
                self::STRATEGY,
                400
            );
        }

        return new ViewStrategyResultBasic(
            self::STRATEGY,
            ViewStrategyResult::OK_STATUS
        );
    }
}
