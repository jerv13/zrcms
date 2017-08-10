<?php

namespace Zrcms\ViewHead\Api\Render;

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
     * @param RenderTag $renderTag
     */
    public function __construct(
        RenderTag $renderTag
    ) {
        $this->renderTag = $renderTag;
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
        );

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
        foreach ($sections as $section) {
            $html .= $this->renderSection($content, $tag, $section);
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
        $html = '';
        foreach ($section as $name => $attributes) {
            $contentHtml = null;

            if (array_key_exists('_content', $attributes)) {
                $contentHtml = (string)$attributes['_content'];
                unset($attributes['_content']);
            }

            $html .= $this->renderTag->__invoke(
                    [
                        'tag' => $tag,
                        'attributes' => $attributes,
                        'content' => $contentHtml
                    ]
                ) . "\n    ";
        }

        return $html;
    }

}
