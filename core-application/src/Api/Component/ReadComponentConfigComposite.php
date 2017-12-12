<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Exception\CanNotReadComponentConfig;
use Zrcms\Core\Model\ServiceAliasComponent;
use Zrcms\ServiceAlias\Api\GetServiceAliasesByNamespace;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigComposite implements ReadComponentConfig
{
    const DEFAULT_CACHE_KEY = 'ZrcmsReadComponentConfigComposite';

    protected $getServiceAliasesByNamespace;
    protected $getServiceFromAlias;
    protected $configReaderServiceAliasNamespace;

    /**
     * @param GetServiceAliasesByNamespace $getServiceAliasesByNamespace
     * @param GetServiceFromAlias          $getServiceFromAlias
     * @param string                       $configReaderServiceAliasNamespace
     */
    public function __construct(
        GetServiceAliasesByNamespace $getServiceAliasesByNamespace,
        GetServiceFromAlias $getServiceFromAlias,
        string $configReaderServiceAliasNamespace = ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER
    ) {
        $this->getServiceAliasesByNamespace = $getServiceAliasesByNamespace;
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->configReaderServiceAliasNamespace = $configReaderServiceAliasNamespace;
    }

    /**
     * @param string $componentConfigUri
     * @param array  $options
     *
     * @return array
     * @throws CanNotReadComponentConfig
     */
    public function __invoke(
        string $componentConfigUri,
        array $options = []
    ): array
    {
        $readComponentConfigServiceAliases = $this->getServiceAliasesByNamespace->__invoke(
            $this->configReaderServiceAliasNamespace
        );

        foreach ($readComponentConfigServiceAliases as $serviceAlias => $readComponentConfigServiceName) {
            /** @var ReadComponentConfig $readComponentConfig */
            $readComponentConfig = $this->getServiceFromAlias->__invoke(
                $this->configReaderServiceAliasNamespace,
                $serviceAlias,
                ReadComponentConfig::class,
                ''
            );
            try {
                $componentConfig = $readComponentConfig->__invoke($componentConfigUri);
            } catch (CanNotReadComponentConfig $e) {
                continue;
            }

            return $componentConfig;
        }

        throw new CanNotReadComponentConfig(
            'No valid component config readers for config location: ' . $componentConfigUri
        );
    }
}
