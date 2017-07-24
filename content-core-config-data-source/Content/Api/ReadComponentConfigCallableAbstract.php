<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Api;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;

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

        $config[ComponentConfigFields::LOCATION] = $callableServiceName;

        return $config;
    }
}
