<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\CoreView\Model\ViewStrategyResult;
use Zrcms\CoreView\Model\ViewStrategyResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DetermineViewStrategyPageVersionId implements DetermineViewStrategy
{
    const STRATEGY = 'page-version-id';

    // Use a middleware to set this
    const ATTRIBUTE_VIEW_PAGE_VERSION_ID = BuildViewPageVersionId::ATTRIBUTE_VIEW_PAGE_VERSION_ID;

    protected $isAllowed;
    protected $isAllowedOptions;

    /**
     * @param IsAllowed $isAllowed
     * @param array     $isAllowedOptions
     */
    public function __construct(
        IsAllowed $isAllowed,
        array $isAllowedOptions = []
    ) {
        $this->isAllowed = $isAllowed;
        $this->isAllowedOptions = $isAllowedOptions;
    }

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
        $pageVersionId = (bool)$request->getAttribute(
            self::ATTRIBUTE_VIEW_PAGE_VERSION_ID,
            null
        );

        if (empty($pageVersionId)) {
            return new ViewStrategyResultBasic(
                self::STRATEGY,
                400
            );
        }

        $allowed = $this->isAllowed->__invoke(
            $request,
            $this->isAllowedOptions
        );

        if (!$allowed) {
            return new ViewStrategyResultBasic(
                self::STRATEGY,
                401
            );
        }

        return new ViewStrategyResultBasic(
            self::STRATEGY,
            ViewStrategyResult::OK_STATUS
        );
    }
}
