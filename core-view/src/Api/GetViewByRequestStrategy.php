<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Exception\LayoutNotFound;
use Zrcms\CoreView\Exception\PageNotFound;
use Zrcms\CoreView\Exception\SiteNotFound;
use Zrcms\CoreView\Exception\ThemeNotFound;
use Zrcms\CoreView\Model\View;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestStrategy implements GetViewByRequest
{
    const OPTION_STRATEGY_NAME = 'strategy-name';

    protected $config;
    protected $serviceContainer;
    protected $defaultStrategyName;

    /**
     * @param array              $config
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultStrategyName
     */
    public function __construct(
        array $config,
        ContainerInterface $serviceContainer,
        string $defaultStrategyName = GetViewByRequestBasic::class
    ) {
        $this->config = $config;
        $this->serviceContainer = $serviceContainer;
        $this->defaultStrategyName = $defaultStrategyName;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Zrcms\CoreView\Exception\ViewDataNotFound
     * @throws \Zrcms\Param\Exception\ParamMissing
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): View {
        $strategyName = Param::get(
            $options,
            static::OPTION_STRATEGY_NAME,
            $this->defaultStrategyName
        );

        $getViewByRequestServiceName = Param::getRequired(
            $this->config,
            $strategyName
        );

        /** @var GetViewByRequest $getViewByRequest */
        $getViewByRequest = $this->serviceContainer->get($getViewByRequestServiceName);

        if (!is_a($getViewByRequest, GetViewByRequest::class)) {
            throw new \Exception(
                'GetViewByRequestStrategy (' . $getViewByRequestServiceName . ')'
                . ' must be instance of: (' . GetViewByRequest::class . ')'
                . ' for service: (' . $getViewByRequestServiceName . ')'
            );
        }

        return $getViewByRequest->__invoke(
            $request,
            $options
        );
    }
}