<?php

namespace Zrcms\CoreBlock\Api\Render;

use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Model\Block;

/**
 * @todo   FINISH ME: Render as a mustache template
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockAsMustacheTemplate implements RenderBlock
{
    const SERVICE_ALIAS = 'mustache-template';

    protected $renderBlockBasic;

    /**
     * @param RenderBlockBasic $renderBlockBasic
     */
    public function __construct(
        RenderBlockBasic $renderBlockBasic
    ) {
        $this->renderBlockBasic = $renderBlockBasic;
    }

    /**
     * @param Block|Content $block
     * @param array         $renderTags ['render-tag' => '{html}']
     * @param array         $options
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        Content $block,
        array $renderTags,
        array $options = []
    ): string {
        return $this->renderBlockBasic->__invoke(
            $block,
            $this->buildMustacheTags($renderTags),
            $options
        );
    }

    /**
     * @todo deal with nested tags
     *
     * @param       $renderTags
     * @param array $mustacheTags
     *
     * @return array
     */
    protected function buildMustacheTags($renderTags, $mustacheTags = [])
    {
        foreach ($renderTags as $tagName => $tagValue) {
            if (!is_array($renderTags[$tagName])) {
                // @todo deal with nested tags $mustacheTags[$tagName .'.' . $subTagName];
                continue;
            }
            $mustacheTags[$tagName] = '{{{' . $tagName . '}}}';
        }

        return $mustacheTags;
    }
}
