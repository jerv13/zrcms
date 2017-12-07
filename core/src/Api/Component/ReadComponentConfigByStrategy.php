<?php

namespace Zrcms\Core\Api\Component;

use Zrcms\Core\Api\GetTypeValue;
use Zrcms\Core\Fields\FieldsComponent;
use Zrcms\Param\Param;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @deprecated Cant work
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigByStrategy implements ReadComponentConfig
{
    const OPTION_COMPONENT_TYPE = 'componentType';

    protected $getTypeValue;
    protected $getServiceFromAlias;
    protected $configReaderServiceAliasNamespace;
    protected $defaultComponentConfigReaderServiceName;

    /**
     * @param GetTypeValue        $getTypeValue
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $configReaderServiceAliasNamespace
     * @param string              $defaultComponentConfigReaderServiceName
     */
    public function __construct(
        GetTypeValue $getTypeValue,
        GetServiceFromAlias $getServiceFromAlias,
        string $configReaderServiceAliasNamespace,
        string $defaultComponentConfigReaderServiceName
    ) {
        $this->getTypeValue = $getTypeValue;
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->configReaderServiceAliasNamespace = $configReaderServiceAliasNamespace;
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
    ): array {
        $componentType = Param::get(
            $options,
            self::OPTION_COMPONENT_TYPE,
            'basic'
        );

        $defaultComponentConfigReaderServiceName = $this->getTypeValue->__invoke(
            $componentType,
            ReadComponentConfig::class,
            $this->defaultComponentConfigReaderServiceName
        );

        $componentConfigReaderServiceAlias = Param::getString(
            $options,
            FieldsComponent::COMPONENT_CONFIG_READER,
            ''
        );

        /** @var ReadComponentConfig $readComponentConfig */
        $readComponentConfig = $this->getServiceFromAlias->__invoke(
            $this->configReaderServiceAliasNamespace,
            $componentConfigReaderServiceAlias,
            ReadComponentConfig::class,
            $this->defaultComponentConfigReaderServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $readComponentConfig);

        $config = $readComponentConfig->__invoke(
            $location,
            $options
        );

        $config[FieldsComponent::COMPONENT_CONFIG_READER] = $componentConfigReaderServiceAlias;

        return $config;
    }
}
