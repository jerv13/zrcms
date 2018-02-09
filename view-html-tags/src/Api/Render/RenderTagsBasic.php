<?php

namespace Zrcms\ViewHtmlTags\Api\Render;

use Reliv\ArrayProperties\Property;

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
     * @throws \Exception
     */
    public function __invoke(
        array $tagsData,
        array $options = []
    ): string {
        $html = '';

        // if has 'tag' is must be a tag
        if (array_key_exists('tag', $tagsData)) {
            throw new \Exception(get_class($this) . ' expects tagsData to be array of tags');
        }

        $options[RenderTag::OPTION_DEPTH] = Property::getInt(
            $options,
            RenderTag::OPTION_DEPTH,
            1
        );

        return $this->renderTags(
            $tagsData,
            $options
        );
    }

    /**
     * @param array $tagsData
     * @param array $options
     *
     * @return string
     */
    public function renderTags(
        array $tagsData,
        array $options = []
    ): string {
        $html = '';

        // if has 'tag' is must be a tag
        if (!array_key_exists('tag', $tagsData)) {
            foreach ($tagsData as $tagData) {
                $html .= $this->renderTags($tagData, $options);
            }

            return $html;
        }

        // @todo fix depth change on recursion so indents are correct

        return $this->renderTag->__invoke(
            $tagsData,
            $options
        );
    }
}
