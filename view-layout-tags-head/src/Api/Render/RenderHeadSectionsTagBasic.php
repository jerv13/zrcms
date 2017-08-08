<?php

namespace Zrcms\ViewLayoutTagsHead\Api\Render;

use Zrcms\Content\Model\Content;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionsTagBasic implements RenderHeadSectionsTag
{
    /**
     * @var RenderTag
     */
    protected $renderTag;

    /**
     * @var array
     */
    protected $availableSections;

    /**
     * @param RenderTag $renderTag
     * @param array     $availableSections
     */
    public function __construct(
        RenderTag $renderTag,
        array $availableSections
    ) {
        $this->renderTag = $renderTag;
        $this->availableSections = $availableSections;
    }

    /**
     * @param Content $content
     * @param array   $renderTags
     * @param array   $options
     *
     * @return string
     */
    public function __invoke(
        Content $content,
        array $renderTags,
        array $options = []
    ): string
    {
        $html = '';

        $tag = Param::getRequired($renderTags, 'tag');
        $sections = Param::getRequired($renderTags, 'sections');

        $html .= $this->renderSections(
                $content,
                $tag,
                $sections
            ) . "\n";

        return $html;
    }

    /**
     * @param Content $content
     * @param string  $tag
     * @param array   $sections
     *
     * @return string
     */
    protected function renderSections(
        Content $content,
        string $tag,
        array $sections
    ): string
    {
        $html = '';
        foreach ($this->availableSections as $section) {
            // Section must be defined, else we can know the order
            if (!array_key_exists($section, $sections)) {
                continue;
            }

            $html .= $this->renderSection($content, $tag, $sections[$section]) . "\n";
        }

        return $html;
    }

    /**
     * @param Content $content
     * @param string  $tag
     * @param array   $section
     *
     * @return string
     */
    protected function renderSection(
        Content $content,
        string $tag,
        array $section
    ): string
    {
        ddd($section);
        $html = '';
        foreach ($section as $name => $attributes) {
            $contentHtml = null;

            if (array_key_exists('_content', $attributes)) {
                $contentHtml = (string)$attributes['_content'];
                unset($attributes['_content']);
            }

            $html .= $this->renderTag->__invoke(
                    $content,
                    [
                        'tag' => $tag,
                        'attributes' => $attributes,
                        'content' => $contentHtml
                    ]
                ) . "\n";
        }

        return $html;
    }

}
