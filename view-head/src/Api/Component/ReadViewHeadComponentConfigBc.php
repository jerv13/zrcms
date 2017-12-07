<?php

namespace Zrcms\ViewHead\Api\Component;

use Zrcms\Core\Api\Component\ReadComponentConfig;
use Zrcms\ViewHead\Api\MergeSectionsBc;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewHeadComponentConfigBc implements ReadComponentConfig
{
    const SERVICE_ALIAS = 'view-head-bc';
    /**
     * @var array
     */
    protected $applicationConfig;

    /**
     * @var array
     */
    protected $applicationConfigBc;

    /**
     * @param array $applicationConfig
     * @param array $applicationConfigBc
     */
    public function __construct(
        array $applicationConfig,
        array $applicationConfigBc
    ) {
        $this->applicationConfig = $this->merge(
            $applicationConfig,
            $applicationConfigBc
        );
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

    /**
     * @param array $applicationConfig
     * @param array $applicationConfigBc
     *
     * @return array
     */
    protected function merge(
        array $applicationConfig,
        array $applicationConfigBc
    ): array
    {
        $metaKey = 'view-layout-tag.head-meta';
        $linkKey = 'view-layout-tag.head-link';
        $scriptKey = 'view-layout-tag.head-script';

        $applicationConfigBcConverted = [
            $metaKey => [
                'tags' => MergeSectionsBc::convertMeta($applicationConfigBc),
            ],
            $linkKey => [
                'sections' => MergeSectionsBc::convertStylesheets($applicationConfigBc),
            ],
            $scriptKey => [
                'sections' => MergeSectionsBc::convertScripts($applicationConfigBc),
            ],
        ];

        if (is_array($applicationConfig[$metaKey])) {
            $applicationConfig[$metaKey]['tags'] = array_merge(
                $applicationConfig[$metaKey]['tags'],
                $applicationConfigBcConverted[$metaKey]['tags']
            );
        } else {
            // throw
        }
        if (is_array($applicationConfig[$linkKey])) {
            $applicationConfig[$linkKey]['sections'] = MergeSectionsBc::keys(
                $applicationConfig[$linkKey]['sections'],
                $applicationConfigBcConverted[$linkKey]['sections']
            );
        } else {
            // throw
        }

        if (is_array($applicationConfig[$scriptKey])) {
            $applicationConfig[$scriptKey]['sections'] = MergeSectionsBc::keys(
                $applicationConfig[$scriptKey]['sections'],
                $applicationConfigBcConverted[$scriptKey]['sections']
            );
        } else {
            // throw
        }

        return $applicationConfig;
    }
}
