<?php

namespace Zrcms\ViewHead\Api;

use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\CoreBlock\Fields\FieldsBlockComponent;
use Zrcms\CoreBlock\Model\BlockComponent;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadLink;
use Zrcms\ViewHead\Api\Render\GetViewLayoutTagsHeadScript;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSectionsBlockComponent implements GetSections
{
    protected $findComponentsBy;

    protected $tagTypeMap
        = [
            GetViewLayoutTagsHeadScript::TAG_TYPE => FieldsBlockComponent::JAVASCRIPT,
            GetViewLayoutTagsHeadLink::TAG_TYPE => FieldsBlockComponent::CSS,
        ];

    protected $tagMap
        = [
            GetViewLayoutTagsHeadScript::TAG_TYPE => 'script',
            GetViewLayoutTagsHeadLink::TAG_TYPE => 'link',
        ];

    protected $blockSectionName = 'modules';

    /**
     * @param FindComponentsBy $findComponentsBy
     */
    public function __construct(
        FindComponentsBy $findComponentsBy
    ) {
        $this->findComponentsBy = $findComponentsBy;
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
        /** @var BlockComponent[] $components */
        $components = $this->findComponentsBy->__invoke(
            [
                'type' => 'block',
            ]
        );

        $filedName = $this->getFieldName($tagType);
        $tag = $this->getTag($tagType);

        $sectionEntries = [];

        /** @var BlockComponent $component */
        foreach ($components as $component) {
            $blockTagConfigs = $component->findProperty(
                $filedName,
                []
            );

            $sectionEntries = $this->getSectionEntries(
                $tag,
                $component,
                $blockTagConfigs,
                $sectionEntries
            );
        }

        $sections = [];
        $sections[$this->blockSectionName] = $sectionEntries;

        return $sections;
    }

    /**
     * @param string         $tag
     * @param BlockComponent $component
     * @param array          $blockTagConfigs
     * @param array          $sectionEntries
     *
     * @return array
     */
    protected function getSectionEntries(
        string $tag,
        BlockComponent $component,
        array $blockTagConfigs,
        array $sectionEntries
    ) {
        if (empty($blockTagConfigs)) {
            return $sectionEntries;
        }
        $sectionEntryName = $component->getType() . '.' . $component->getName() . ':';
        $moduleDirectory = $component->getModuleDirectory();

        foreach ($blockTagConfigs as $blockFilePath) {
            $scheme = parse_url($blockFilePath, PHP_URL_SCHEME);
            $filePath = parse_url($blockFilePath, PHP_URL_PATH);

            $absoluteFilePathUri = $scheme . $moduleDirectory . '/' . $filePath;

            $sectionEntries[$sectionEntryName] = $this->getSectionEntry($tag, $absoluteFilePathUri);
        }

        return $sectionEntries;
    }

    /**
     * @param string $tag
     * @param string $absoluteFilePathUri
     *
     * @return array
     */
    protected function getSectionScriptEntry(
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
