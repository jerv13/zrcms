<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Api;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentRegistryFields;
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
     * @throws \Exception
     */
    public function __invoke(
        string $location,
        array $options = []
    ): array
    {
        $componentConfigReaderServiceName = Param::get(
            $options,
            ComponentRegistryFields::COMPONENT_CONFIG_READER,
            $this->defaultComponentConfigReaderServiceName
        );

        /** @var ReadComponentConfig $componentConfigReader */
        $componentConfigReader = $this->serviceContainer->get($componentConfigReaderServiceName);

        if (get_class($componentConfigReader) == get_class($this)) {
            throw new \Exception(
                'Class ' . get_class($this) . ' can not use itself as service.'
            );
        }

        $config = $componentConfigReader->__invoke(
            $location,
            $options
        );

        $config[ComponentRegistryFields::COMPONENT_CONFIG_READER] = $componentConfigReaderServiceName;

        return $config;
    }
}
