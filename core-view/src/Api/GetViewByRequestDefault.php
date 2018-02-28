<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Reliv\Json\Json;
use Zrcms\CoreView\Api\ViewBuilder\BuildRequestedView;
use Zrcms\CoreView\Api\ViewBuilder\DetermineViewStrategy;
use Zrcms\CoreView\Api\ViewBuilder\MutateView;
use Zrcms\CoreView\Exception\BuildRequestedViewStrategyInvalid;
use Zrcms\CoreView\Exception\InvalidGetViewByRequest;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestDefault implements GetViewByRequest
{
    protected $determineViewStrategy;
    protected $buildRequestedView;
    protected $mutateView;

    /**
     * @param DetermineViewStrategy $determineViewStrategy
     * @param BuildRequestedView    $buildRequestedView
     * @param MutateView            $mutateView
     */
    public function __construct(
        DetermineViewStrategy $determineViewStrategy,
        BuildRequestedView $buildRequestedView,
        MutateView $mutateView
    ) {
        $this->determineViewStrategy = $determineViewStrategy;
        $this->buildRequestedView = $buildRequestedView;
        $this->mutateView = $mutateView;
    }

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
    ): View {
        $strategyResult = $this->determineViewStrategy->__invoke(
            $request,
            Property::getArray(
                $options,
                self::OPTION_DETERMINE_VIEW_STRATEGY_OPTIONS,
                []
            )
        );

        if (!$strategyResult->isOk()) {
            throw new BuildRequestedViewStrategyInvalid(
                'View strategy could not be determined, '
                . ' got status: ' . $strategyResult->getStatus()
                . ' for strategy: ' . Json::encode($strategyResult->getStrategy())
            );
        }

        $view = $this->buildRequestedView->__invoke(
            $request,
            $strategyResult->getStrategy(),
            Property::getArray(
                $options,
                self::OPTION_BUILD_REQUESTED_VIEW_OPTIONS,
                []
            )
        );

        return $this->mutateView->__invoke(
            $request,
            $view,
            Property::getArray(
                $options,
                self::OPTION_BUILD_REQUESTED_VIEW_OPTIONS,
                []
            )
        );
    }
}
