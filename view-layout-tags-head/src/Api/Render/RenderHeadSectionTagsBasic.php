<?php

namespace Zrcms\ViewLayoutTagsHead\Api\Render;

use Zrcms\Content\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagsBasic implements RenderTagContent
{
    protected $availableSections;

    /**
     * @param array $availableSections
     */
    public function __construct(
        array $availableSections
    ) {
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
        foreach ($renderTags as $tag => $sections) {
            $html .= $this->renderSections($sections) . "\n";
        }

        return $html;
    }

    /**
     * @param array $sections
     *
     * @return string
     */
    protected function renderSections(array $sections)
    {
        $html = '';
        foreach ($this->availableSections as $section) {
            // Section must be defined, else we can know the order
            if (!array_key_exists($section, $sections)) {
                continue;
            }

            
        }

        return $html;
    }

    protected function renderTag(string $name, array $attributes, $content = null)
    {

    }
}
