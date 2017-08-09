<?php

namespace Zrcms\ViewHead\Api\Repository;

use Zrcms\ContentCore\View\Api\Repository\ReadViewLayoutTagsComponentConfig;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadLink;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadMeta;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadScript;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewHeadComponentConfigBc implements ReadViewLayoutTagsComponentConfig
{
    /**
     * @var array
     */
    protected $rcmConfig;

    /**
     * @param array $applicationConfig
     */
    public function __construct(
        array $applicationConfig,
        array $applicationConfigBc
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

    /**
     * @param array $applicationConfigBc
     *
     * @return array
     */
    protected function convert(
        array $applicationConfigBc
    ): array
    {
        $applicationConfigBc = [
            GetViewLayoutTagsHeadMeta::RENDER_TAG_META => [
                'tag' => 'meta',
                'tags' => [],
            ],
            GetViewLayoutTagsHeadLink::RENDER_TAG_LINK => [
                'tag' => 'link',
                'sections' => [],
            ],
            GetViewLayoutTagsHeadScript::RENDER_TAG_SCRIPT => [
                'tag' => 'script',
                'sections' => [],
            ],
        ];

        foreach ($applicationConfigBc['meta'] as $nameAttribute => $value) {
            $applicationConfigBc['meta']['tags'][$nameAttribute] = [];
            if (array_key_exists('content', $value)) {
                $applicationConfigBc;
            }
        }
    }
}
