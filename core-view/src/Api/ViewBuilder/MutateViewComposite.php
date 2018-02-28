<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class MutateViewComposite implements MutateView
{
    protected $mutatorConfig;
    protected $serviceContainer;

    /**
     * @param array              $mutatorConfig
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(
        array $mutatorConfig,
        ContainerInterface $serviceContainer
    ) {
        $this->setConfig($mutatorConfig);
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param array $mutatorConfig
     *
     * @return void
     */
    protected function setConfig(array $mutatorConfig)
    {
        $queue = new \SplPriorityQueue();

        foreach ($mutatorConfig as $viewMutatorServiceName => $priority) {
            $queue->insert($viewMutatorServiceName, $priority);
        }

        foreach ($queue as $viewMutatorServiceName) {
            $this->mutatorConfig[] = $viewMutatorServiceName ;
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param View                   $view
     * @param array                  $options
     *
     * @return View
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        View $view,
        array $options = []
    ): View {
        foreach ($this->mutatorConfig as $viewMutatorServiceName) {
            $viewMutator = $this->serviceContainer->get($viewMutatorServiceName);
            $view = $viewMutator->__invoke(
                $request,
                $view,
                $options
            );
        }

        return $view;
    }
}
