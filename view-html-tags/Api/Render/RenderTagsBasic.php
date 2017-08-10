<?php

namespace Zrcms\ViewHtmlTags\Api\Render;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderTagsBasic implements RenderTags
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
     * @param array $tagsData
     * @param array $options
     *
     * @return string
     */
    public function __invoke(
        array $tagsData,
        array $options = []
    ): string
    {
        $html = '';

        // if has 'tag' is must be a tag
        if (array_key_exists('tag', $tagsData)) {
            return $this->renderTag->__invoke(
                $tagsData
            );
        }

        foreach ($tagsData as $tagData) {
            $html .= $this->__invoke($tagData) . "\n";
        }

        return $html;
    }
}
