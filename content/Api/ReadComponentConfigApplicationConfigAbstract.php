<?php

namespace Zrcms\Content\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ReadComponentConfigApplicationConfigAbstract implements ReadComponentConfig
{
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
     * @param string $configKey
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $configKey,
        array $options = []
    ): array
    {
        if (!array_key_exists($configKey, $this->applicationConfig)) {
            throw new \Exception("Config key ({$configKey}) not found");
        }

        return $this->applicationConfig[$configKey];
    }
}
