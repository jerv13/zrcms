<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Model\ViewStrategyResult;
use Zrcms\CoreView\Model\ViewStrategyResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DetermineViewStrategyComposite implements DetermineViewStrategy
{
    protected $determineStrategyConfig;
    protected $serviceContainer;

    /**
     * @param array              $determineStrategyConfig
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(
        array $determineStrategyConfig,
        ContainerInterface $serviceContainer
    ) {
        $this->setConfig($determineStrategyConfig);
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param array $determineStrategyConfig
     *
     * @return void
     */
    protected function setConfig(array $determineStrategyConfig)
    {
        $queue = new \SplPriorityQueue();

        foreach ($determineStrategyConfig as $determineStrategyServiceName => $priority) {
            $queue->insert($determineStrategyServiceName, $priority);
        }

        foreach ($queue as $determineStrategyServiceName) {
            $this->determineStrategyConfig[] = $determineStrategyServiceName;
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return ViewStrategyResult
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): ViewStrategyResult {
        foreach ($this->determineStrategyConfig as $determineStrategyServiceName) {
            /** @var DetermineViewStrategy $determineStrategy */
            $determineStrategy = $this->serviceContainer->get($determineStrategyServiceName);
            $strategyResult = $determineStrategy->__invoke(
                $request,
                $options
            );

            if ($strategyResult->isOk()) {
                return $strategyResult;
            }
        }

        return new ViewStrategyResultBasic(
            null,
            400
        );
    }
}
