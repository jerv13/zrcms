<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\CoreView\Model\ViewStrategyResult;
use Zrcms\CoreView\Model\ViewStrategyResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DetermineViewStrategyDefaultPublishedAny implements DetermineViewStrategy
{
    const STRATEGY = 'published-any';
    // This comes from client
    const PARAM_VIEW_PUBLISHED_ANY = 'view-published-any';
    // Use a middleware to set this
    const ATTRIBUTE_VIEW_PUBLISHED_ANY = 'zrcms-view-published-any';

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
        $publishedAnyAttribute = (bool)$request->getAttribute(
            self::ATTRIBUTE_VIEW_PUBLISHED_ANY,
            false
        );

        $queryParams = $request->getQueryParams();

        $publishedAny = Property::getBool(
            $queryParams,
            self::PARAM_VIEW_PUBLISHED_ANY,
            $publishedAnyAttribute
        );

        if (!$publishedAny) {
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
