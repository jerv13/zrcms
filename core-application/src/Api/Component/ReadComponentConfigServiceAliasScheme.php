<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Exception\CanNotReadComponentConfig;
use Zrcms\Core\Model\ServiceAliasComponent;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigServiceAliasScheme implements ReadComponentConfig
{
    protected $getServiceFromAlias;
    protected $configReaderServiceAliasNamespace;
    protected $defaultServiceAliasScheme;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $configReaderServiceAliasNamespace
     * @param string              $defaultServiceAliasScheme
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $configReaderServiceAliasNamespace = ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER,
        string $defaultServiceAliasScheme = ReadComponentConfigJsonFile::SERVICE_ALIAS
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->configReaderServiceAliasNamespace = $configReaderServiceAliasNamespace;
        $this->defaultServiceAliasScheme = $defaultServiceAliasScheme;
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
    ): array {
        $serviceAliasScheme = parse_url($componentConfigUri, PHP_URL_SCHEME);

        if (empty($serviceAliasScheme)) {
            $serviceAliasScheme = $this->defaultServiceAliasScheme;
        }

        /** @var ReadComponentConfig $readComponentConfig */
        $readComponentConfig = $this->getServiceFromAlias->__invoke(
            $this->configReaderServiceAliasNamespace,
            $serviceAliasScheme,
            ReadComponentConfig::class,
            ''
        );

        return $readComponentConfig->__invoke(
            $componentConfigUri,
            $options
        );
    }
}
