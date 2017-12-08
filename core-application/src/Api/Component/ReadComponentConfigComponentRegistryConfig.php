<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Param\Param;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigComponentRegistryConfig implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'component-registry-config';
    const READER_PROTOCOL = 'component-registry-config://';

    /**
     * @var array
     */
    protected $registry;

    /**
     * @param array $registry
     */
    public function __construct(
        array $registry
    ) {
        $this->registry = $registry;
    }

    /**
     * @param string $configKey
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $configKey,
        array $options = []
    ): array {
        AssertValidReaderProtocol::invoke(self::READER_PROTOCOL, $configKey);

        if (!array_key_exists($configKey, $this->registry)) {
            throw new \Exception("Config key ({$configKey}) not found in component registry");
        }

        $componentConfig = $this->registry[$configKey];

        Param::assertHas(
            $componentConfig,
            FieldsComponentConfig::MODULE_DIRECTORY
        );

        $componentConfig[FieldsComponentConfig::CONFIG_LOCATION] = $configKey;

        return $componentConfig;
    }
}
