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
    const SERVICE_ALIAS = 'view-head';
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

        ddd($this->applicationConfig);
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
        $applicationConfigBc = $this->convert($applicationConfigBc);

        return array_merge($applicationConfigBc, $applicationConfig);
    }

    /**
     * @param array $applicationConfigBc
     *
     * @return array
     */
    protected function convert(
        array $applicationConfig,
        array $applicationConfigBc
    ): array
    {
        $metaKey = GetViewLayoutTagsHeadMeta::RENDER_TAG_META;
        $linkKey = GetViewLayoutTagsHeadLink::RENDER_TAG_LINK;
        $scriptKey = GetViewLayoutTagsHeadScript::RENDER_TAG_SCRIPT;

        if (!isset($applicationConfig[$metaKey])) {
            $applicationConfig[$metaKey] = [];
        }

        $applicationConfig[$metaKey] = array_merge()

        if (!isset($applicationConfig[$linkKey])) {
            $applicationConfig[$linkKey] = [];
        }

        if (!isset($applicationConfig[$scriptKey])) {
            $applicationConfig[$scriptKey] = [];
        }

        $applicationConfigBcConverted = [
            $metaKey => [
                'tags' => [],
            ],
            $linkKey => [
                'sections' => [],
            ],
            $scriptKey => [
                'sections' => [],
            ],
        ];

        foreach ($applicationConfigBc['headMetaName'] as $nameAttribute => $value) {
            $tagAttributes = [
                'name' => $nameAttribute,
                'content' => $value['content']
            ];

            if (isset($value['modifiers'])) {
                // @todo deal with BC modifiers
            }

            $applicationConfigBcConverted[$metaKey]['tags'][$nameAttribute] = $tagAttributes;
        }

        foreach ($applicationConfigBc['stylesheets'] as $section => $data) {
            foreach ($data as $href => $options) {
                $tagAttributes = [
                    'href' => $href,
                ];

                if (isset($options['media'])) {
                    $tagAttributes['media'] = $options['media'];
                }

                if (isset($options['conditionalStylesheet'])) {
                    // @todo deal with BC conditionalStylesheet
                }

                $applicationConfigBcConverted[$linkKey]['sections'][$section][$href] = $tagAttributes;
            }
        }

        foreach ($applicationConfigBc['scripts'] as $section => $data) {
            foreach ($data as $src => $options) {
                $tagAttributes = [
                    'src' => $src,
                ];

                if (isset($options['type'])) {
                    $tagAttributes['type'] = $options['type'];
                }

                if (isset($options['attrs'])) {
                    foreach ($options['attrs'] as $name => $attrValue) {
                        $tagAttributes[$name] = $attrValue;
                    }
                }

                $applicationConfigBcConverted[$scriptKey]['sections'][$src] = $tagAttributes;
            }
        }

        return $applicationConfigBcConverted;
    }
}
