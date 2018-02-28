<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreView\Exception\BuildRequestedViewStrategyInvalid;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildRequestedViewByConfig implements BuildRequestedView
{
    const OPTION_BUILD_VIEW_OPTIONS = 'build-view-options';

    protected $strategyConfig;
    protected $serviceContainer;

    /**
     * @param array              $strategyConfig
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(
        array $strategyConfig,
        ContainerInterface $serviceContainer
    ) {
        $this->strategyConfig = $strategyConfig;
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param ServerRequestInterface $request
     * @param string                 $strategy
     * @param array                  $options
     *
     * @return View
     * @throws BuildRequestedViewStrategyInvalid
     */
    /**
     * @param ServerRequestInterface $request
     * @param string                 $strategy
     * @param array                  $options
     *
     * @return View
     * @throws BuildRequestedViewStrategyInvalid
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws ViewDataNotFound
     */
    public function __invoke(
        ServerRequestInterface $request,
        string $strategy,
        array $options = []
    ): View {
        $buildViewServiceName = Property::getString(
            $this->strategyConfig,
            $strategy
        );

        if (empty($buildViewServiceName)) {
            throw new BuildRequestedViewStrategyInvalid(
                'Strategy API service name not found: ' . $strategy
            );
        }

        if (!$this->serviceContainer->has($buildViewServiceName)) {
            throw new BuildRequestedViewStrategyInvalid(
                'Strategy API service not found: ' . $buildViewServiceName
            );
        }
        $buildViewService = $this->serviceContainer->get($buildViewServiceName);

        if (!$buildViewService instanceof BuildView) {
            throw new BuildRequestedViewStrategyInvalid(
                'Strategy API : (' . $buildViewServiceName . ')'
                . ' must implement: ' . BuildView::class
            );
        }

        $buildViewOptions = Property::getArray(
            $options,
            self::OPTION_BUILD_VIEW_OPTIONS,
            []
        );

        $buildViewOptions[BuildView::OPTION_VIEW_STRATEGY] = $strategy;

        return $buildViewService->__invoke(
            $request,
            $buildViewOptions
        );
    }
}
