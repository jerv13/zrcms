<?php

namespace Zrcms\CoreApplicationState\Api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetApplicationStateByConfig implements GetApplicationState
{
    protected $config;
    protected $serviceContainer;
    protected $debug;

    /**
     * @param array              $config
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(
        array $config,
        ContainerInterface $serviceContainer
    ) {
        $this->config = $config;
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): array {
        $appState = [];

        /**
         * @var string $key
         * @var string $getApplicationStateServiceName
         */
        foreach ($this->config as $key => $getApplicationStateServiceName) {
            /** @var GetApplicationState $getApplicationStateService */
            $getApplicationStateService = $this->serviceContainer->get($getApplicationStateServiceName);

            if (!is_a($getApplicationStateService, GetApplicationState::class)) {
                throw new \Exception(
                    $getApplicationStateServiceName . ' must be instance of ' . GetApplicationState::class
                );
            }

            $appState[$key] = $getApplicationStateService->__invoke(
                $request,
                $options
            );
        }

        return $appState;
    }
}
