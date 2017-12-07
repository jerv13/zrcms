<?php

namespace Zrcms\Core\Api\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigComponentRegistryConfig implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'component-registry-config';

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
        if (!array_key_exists($configKey, $this->registry)) {
            throw new \Exception("Config key ({$configKey}) not found in component registry");
        }

        return $this->registry[$configKey];
    }
}
