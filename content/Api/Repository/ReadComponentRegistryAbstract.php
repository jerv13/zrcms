<?php

namespace Zrcms\Content\Api\Repository;

use Zrcms\Content\Model\ComponentConfigFields;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentRegistryFields;
use Zrcms\Param\Param;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ReadComponentRegistryAbstract implements ReadComponentRegistry
{
    /**
     * @var array
     */
    protected $registry;

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
    protected $defaultComponentConfReaderServiceAlias;

    /**
     * @param array               $registry
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $serviceAliasNamespace
     * @param string              $defaultComponentConfReaderServiceAlias
     */
    public function __construct(
        array $registry,
        GetServiceFromAlias $getServiceFromAlias,
        string $serviceAliasNamespace,
        string $defaultComponentConfReaderServiceAlias = ReadComponentConfig::class
    ) {
        $this->registry = $registry;
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = $serviceAliasNamespace;
        $this->defaultComponentConfReaderServiceAlias = $defaultComponentConfReaderServiceAlias;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $options = []
    ): array
    {
        $componentConfigs = [];

        foreach ($this->registry as $componentNameOptional => $configLocation) {

            $componentOptions = [];
            $componentName = $componentNameOptional;

            $readComponentConfigServiceAlias = $this->defaultComponentConfReaderServiceAlias;

            if (is_array($configLocation)) {
                $componentOptions = $configLocation;
                $configLocation = Param::getRequired(
                    $componentOptions,
                    ComponentRegistryFields::CONFIG_LOCATION,
                    new \Exception(
                        'Component location is required for: ' . json_encode($configLocation)
                        . ' in ' . $componentName
                    )
                );

                $readComponentConfigServiceAlias = Param::get(
                    $componentOptions,
                    ComponentRegistryFields::COMPONENT_CONFIG_READER,
                    ''
                );

                $componentName = Param::get(
                    $componentOptions,
                    ComponentRegistryFields::NAME,
                    $componentNameOptional
                );
            }

            /** @var ReadComponentConfig $readComponentConfig */
            $readComponentConfig = $this->getServiceFromAlias->__invoke(
                $this->serviceAliasNamespace,
                $readComponentConfigServiceAlias,
                ReadComponentConfig::class,
                $this->defaultComponentConfReaderServiceAlias
            );

            $componentConfig = $readComponentConfig->__invoke(
                $configLocation,
                $componentOptions
            );

            if (!is_string($componentName)) {
                new \Exception(
                    'Component ' . ComponentConfigFields::NAME . ' is required and must be string for: '
                    . json_encode($componentConfig)
                );
            }

            Param::assertNotHas(
                $componentConfig,
                $componentName,
                new \Exception(
                    'Duplicate component name configured: ' . $componentName
                    . ' for ' . json_encode($componentConfig)
                )
            );

            $componentConfigs[$componentName] = $componentConfig;
        }

        return $componentConfigs;
    }
}
