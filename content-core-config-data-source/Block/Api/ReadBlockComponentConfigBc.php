<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBlockComponentConfigBc implements ReadBlockComponentConfig
{
    /**
     * @var array
     */
    protected $pluginConfig;

    /**
     * @param array $pluginConfig
     */
    public function __construct(
        array $pluginConfig
    ) {
        $this->pluginConfig = $pluginConfig;
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
        return $this->pluginConfig[$configKey];
    }
}
