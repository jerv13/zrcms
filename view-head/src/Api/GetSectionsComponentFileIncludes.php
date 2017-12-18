<?php

namespace Zrcms\ViewHead\Api;

use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Core\Fields\FieldsComponent;
use Zrcms\Core\Model\Component;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadLink;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadScript;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSectionsComponentFileIncludes implements GetSections
{
    const DEFAULT_SECTION_NAME = 'modules';
    const DEFAULT_COMPONENT_TYPE = 'block';

    protected $findComponentsBy;

    protected $tagTypeMap
        = [
            GetViewLayoutTagsHeadScript::TAG_TYPE => FieldsComponent::JAVASCRIPT,
            GetViewLayoutTagsHeadLink::TAG_TYPE => FieldsComponent::CSS,
        ];

    protected $tagMap
        = [
            GetViewLayoutTagsHeadScript::TAG_TYPE => 'script',
            GetViewLayoutTagsHeadLink::TAG_TYPE => 'link',
        ];

    protected $sectionName;

    protected $componentType;

    /**
     * @param FindComponentsBy $findComponentsBy
     * @param string           $sectionName
     * @param string           $componentType
     */
    public function __construct(
        FindComponentsBy $findComponentsBy,
        string $sectionName = self::DEFAULT_SECTION_NAME,
        string $componentType = self::DEFAULT_COMPONENT_TYPE
    ) {
        $this->findComponentsBy = $findComponentsBy;
        $this->sectionName = $sectionName;
        $this->componentType = $componentType;
    }

    /**
     * @param string $tagType
     * @param array  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        string $tagType,
        array $options = []
    ): array {
        /** @var Component[] $components */
        $components = $this->findComponentsBy->__invoke(
            [
                'type' => $this->componentType,
            ]
        );

        $filedName = $this->getFieldName($tagType);
        $tag = $this->getTag($tagType);

        $filePaths = [];

        /** @var Component $component */
        foreach ($components as $component) {
            $tagConfigs = $component->findProperty(
                $filedName,
                []
            );

            $filePaths = $this->getFilesPaths(
                $tag,
                $component,
                $tagConfigs,
                $filePaths
            );
        }

        $sections = [
            $this->componentType . '.' . $this->sectionName => [
                $this->sectionName => [
                    '__file-includes' => $filePaths,
                ],
            ],
        ];

        return $sections;
    }

    /**
     * @param string    $tag
     * @param Component $component
     * @param array     $tagConfigs
     * @param array     $filePaths
     *
     * @return array
     * @throws \Exception
     */
    protected function getFilesPaths(
        string $tag,
        Component $component,
        array $tagConfigs,
        array $filePaths
    ) {
        if (empty($tagConfigs)) {
            return $filePaths;
        }
        $sourceName = $component->getType() . '.' . $component->getName() . ':';
        $moduleDirectory = $component->getModuleDirectory();
        $index = 0;

        foreach ($tagConfigs as $filePath) {
            $scheme = parse_url($filePath, PHP_URL_SCHEME);
            $filePath = parse_url($filePath, PHP_URL_PATH);

            if (!empty($scheme)) {
                $scheme = $scheme . ':';
            }

            if (empty($filePath)) {
                throw new \Exception(
                    'File path can not be empty for component: ' . $sourceName
                );
            }

            $absoluteFilePathUri = $scheme . $moduleDirectory . '/' . $filePath;

            $filePaths[$sourceName . '-' . $index] = $this->getSectionEntry($tag, $absoluteFilePathUri);
            $index++;
        }

        return $filePaths;
    }

    /**
     * @param string $tag
     * @param string $absoluteFilePathUri
     *
     * @return array
     */
    protected function getSectionEntry(
        string $tag,
        string $absoluteFilePathUri
    ) {
        return [
            'tag' => $tag,
            'attributes' => [
                'src' => $absoluteFilePathUri,
                'type' => "text/javascript",
            ],
        ];
    }

    /**
     * @param string $tag
     * @param string $absoluteFilePathUri
     *
     * @return array
     */
    protected function getSectionScriptLink(
        string $tag,
        string $absoluteFilePathUri
    ) {
        return [
            'tag' => $tag,
            'attributes' => [
                'src' => $absoluteFilePathUri,
                'type' => "text/javascript",
            ],
        ];
    }

    /**
     * @param string $tagType
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getFieldName(string $tagType)
    {
        if (!array_key_exists($tagType, $this->tagTypeMap)) {
            throw new \Exception('TagType not supported: ' . $tagType);
        }

        return $this->tagTypeMap[$tagType];
    }

    /**
     * @param string $tagType
     *
     * @return mixed
     * @throws \Exception
     */
    protected function getTag(string $tagType)
    {
        if (!array_key_exists($tagType, $this->tagMap)) {
            throw new \Exception('TagType not supported: ' . $tagType);
        }

        return $this->tagTypeMap[$tagType];
    }

}
