<?php

namespace Zrcms\Content\Api;

use Zrcms\Content\Model\PropertiesComponent;
use Zrcms\Param\Param;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ReadComponentConfigBasicAbstract implements ReadComponentConfig
{
    /**
     * @var GetServiceFromAlias
     */
    protected $getServiceFromAlias;

    /**
     * @var string
     */
    protected $serviceAliasNamespace;

    /**
     * @var string
     */
    protected $defaultComponentConfigReaderServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $serviceAliasNamespace
     * @param string              $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $serviceAliasNamespace,
        string $defaultComponentConfigReaderServiceName
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = $serviceAliasNamespace;
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
        $componentConfigReaderServiceAlias = Param::getString(
            $options,
            PropertiesComponent::COMPONENT_CONFIG_READER,
            ''
        );

        /** @var ReadComponentConfig $componentConfigReader */
        $componentConfigReader = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $componentConfigReaderServiceAlias,
            ReadComponentConfig::class,
            $this->defaultComponentConfigReaderServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $componentConfigReader);

        $config = $componentConfigReader->__invoke(
            $location,
            $options
        );

        $config[PropertiesComponent::COMPONENT_CONFIG_READER] = $componentConfigReaderServiceAlias;

        return $config;
    }
}