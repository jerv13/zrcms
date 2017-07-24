<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Api;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ReadComponentConfigBasicAbstract implements ReadComponentConfig
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultComponentConfigReaderServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultComponentConfigReaderServiceName
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultComponentConfigReaderServiceName = $defaultComponentConfigReaderServiceName;
    }

    /**
     * @param string $location (directory or location)
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        string $location,
        array $options = []
    ): array
    {
        $componentConfigReaderServiceName = Param::get(
            $options,
            ComponentConfigFields::COMPONENT_CONFIG_READER,
            $this->defaultComponentConfigReaderServiceName
        );

        /** @var ReadComponentConfig $componentConfigReader */
        $componentConfigReader = $this->serviceContainer->get($componentConfigReaderServiceName);

        $config = $componentConfigReader->__invoke(
            $location,
            $options
        );

        $config[ComponentConfigFields::COMPONENT_CONFIG_READER] = $componentConfigReaderServiceName;

        return $config;
    }
}
