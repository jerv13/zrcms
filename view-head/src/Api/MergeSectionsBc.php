<?php

namespace Zrcms\ViewHead\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class MergeSectionsBc
{
    protected static $newKeysMap
        = [
            'pre-core' => 'pre-rcm',
            'core' => 'rcm',
            'post-core' => 'post-rcm',
        ];

    /**
     * @param array $availableSections
     * @param array $availableSectionsBc
     *
     * @return array
     */
    public static function values(
        array $availableSections,
        array $availableSectionsBc
    ): array
    {
        $availableSectionsMerged = [];

        foreach ($availableSections as $availableSection) {
            if (isset(self::$newKeysMap[$availableSection])) {
                $availableSectionsMerged[] = self::$newKeysMap[$availableSection];
            }
            $availableSectionsMerged[] = $availableSection;
        }

        // @todo might add some checking in case some keys change
        //foreach ($availableSectionsBc as $availableSectionBc) {
        //    if (!in_array($availableSectionBc, $availableSectionsMerged)) {
        //        throw new \Exception('undefined key');
        //    }
        //}

        return $availableSectionsMerged;
    }

    /**
     * @param array $sections
     * @param array $sectionsBc
     *
     * @return array
     */
    public static function keys(
        array $sections,
        array $sectionsBc
    ): array
    {
        $sectionsMerged = [];

        foreach ($sections as $section => $value) {
            if (isset(self::$newKeysMap[$section])) {
                $sectionsMerged[self::$newKeysMap[$section]] = [];
            }
            $sectionsMerged[$section] = $value;
        }

        foreach ($sectionsBc as $sectionBc => $value) {
            if (is_array($value) && !empty($value)) {
                $sectionsMerged[$sectionBc] = array_merge(
                    $sectionsMerged[$sectionBc],
                    $value
                );
            }
        }

        return $sectionsMerged;
    }

    /**
     * @param $applicationConfigBc
     *
     * @return array
     */
    public static function convertMeta($applicationConfigBc)
    {
        if (!isset($applicationConfigBc['headMetaName'])) {
            return [];
        }

        $config = [];

        foreach ($applicationConfigBc['headMetaName'] as $nameAttribute => $value) {
            $tag = [
                'tag' => 'meta',
                'attributes' => [
                    'name' => $nameAttribute,
                    'content' => $value['content']
                ],
            ];

            if (isset($value['modifiers'])) {
                // @todo deal with BC modifiers
            }

            $config[$nameAttribute] = $tag;
        }

        return $config;
    }

    /**
     * @param $applicationConfigBc
     *
     * @return array
     */
    public static function convertStylesheets($applicationConfigBc)
    {
        if (!isset($applicationConfigBc['stylesheets'])) {
            return [];
        }

        $config = [];

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

                if (!isset($config[$section])) {
                    $config[$section] = [];
                }

                if (!isset($options['rel'])) {
                    $tagAttributes['rel'] = 'stylesheet';
                }

                if (!isset($options['type'])) {
                    $tagAttributes['type'] = 'text/css';
                }

                $config[$section][$href] = $tagAttributes;
            }
        }

        return $config;
    }

    /**
     * @param $applicationConfigBc
     *
     * @return array
     */
    public static function convertScripts($applicationConfigBc)
    {
        if (!isset($applicationConfigBc['scripts'])) {
            return [];
        }

        $config = [];

        foreach ($applicationConfigBc['scripts'] as $section => $data) {
            foreach ($data as $src => $options) {
                $tagAttributes = [
                    'src' => $src,
                ];

                if (isset($options['type'])) {
                    $tagAttributes['type'] = $options['type'];
                } else {
                    $tagAttributes['type'] = 'text/javascript';
                }

                if (isset($options['attrs'])) {
                    foreach ($options['attrs'] as $name => $attrValue) {
                        $tagAttributes[$name] = $attrValue;
                    }
                }

                if (!isset($config[$section])) {
                    $config[$section] = [];
                }

                $config[$section][$src] = $tagAttributes;
            }
        }

        return $config;
    }
}
