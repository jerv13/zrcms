<?php

namespace Zrcms\CoreApplication\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigApplicationConfig implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'app-config';

    /**
     * @var array
     */
    protected $applicationConfig;

    /**
     * @param array $applicationConfig
     */
    public function __construct(
        array $applicationConfig
    ) {
        $this->applicationConfig = $applicationConfig;
    }

    /**
     * @param string $configLocation
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $configLocation,
        array $options = []
    ): array {
        $componentConfig = $this->getValueFromConfigPath(
            $this->applicationConfig,
            $configLocation
        );

        if (!is_array($componentConfig)) {
            throw new \Exception("Config location ({$configLocation}) not found");
        }

        return $componentConfig;
    }

    /**
     * @param array  $array
     * @param string $configKey
     *
     * @return array|mixed|null
     */
    protected function getValueFromConfigPath(
        array &$array, string $configKey
    ) {
        $parents = explode('.', $configKey);

        $ref = &$array;

        foreach ((array) $parents as $parent) {
            if (is_array($ref) && array_key_exists($parent, $ref)) {
                $ref = &$ref[$parent];
            } else {
                return null;
            }
        }
        return $ref;
    }
}
