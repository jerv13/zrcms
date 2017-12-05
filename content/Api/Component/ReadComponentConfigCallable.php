<?php

namespace Zrcms\Content\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Fields\FieldsComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigCallable implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'callable-service';

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
    ): array {
        $callableService = $this->serviceContainer->get($callableServiceName);

        $config = $callableService->__invoke();

        $config[FieldsComponentConfig::CONFIG_LOCATION] = $callableServiceName;

        return $config;
    }
}
