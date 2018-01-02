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
     * @param array                  $appState
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $appState = [],
        array $options = []
    ): array {
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

            $moreAppState = $getApplicationStateService->__invoke(
                $request,
                $appState,
                $options
            );

            $appState = array_merge($appState, $moreAppState);
        }

        return $appState;
    }
}
