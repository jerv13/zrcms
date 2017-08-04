<?php

namespace Zrcms\Content\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Model\PropertiesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ReadComponentConfigCallableAbstract implements ReadComponentConfig
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(
        $serviceContainer
    ) {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param string $callableServiceName
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $callableServiceName,
        array $options = []
    ): array
    {
        $callableService = $this->serviceContainer->get($callableServiceName);

        $config = $callableService->__invoke();

        $config[PropertiesComponent::CONFIG_LOCATION] = $callableServiceName;

        return $config;
    }
}
