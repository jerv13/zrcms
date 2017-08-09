<?php

namespace Zrcms\ContentCore\Container\Api\Render;

use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Block\Api\Render\RenderBlock;
use Zrcms\ContentCore\Container\Api\WrapRenderedContainer;
use Zrcms\ContentCore\Container\Model\Container;

class RenderContainerRows implements RenderContainer
{
    /**
     * @var RenderBlock
     */
    protected $renderBlock;

    /**
     * @var WrapRenderedContainer
     */
    protected $wrapRenderedContainer;

    /**
     * @param RenderBlock           $renderBlock
     * @param WrapRenderedContainer $wrapRenderedContainer
     */
    public function __construct(
        RenderBlock $renderBlock,
        WrapRenderedContainer $wrapRenderedContainer
    ) {
        $this->renderBlock = $renderBlock;
        $this->wrapRenderedContainer = $wrapRenderedContainer;
    }

    /**
     * @param Container|Content $container
     * @param array             $renderTags ['render-tag' => '{html}']
     * @param array             $options
     *
     * @return string
     */
    public function __invoke(
        Content $container,
        array $renderTags,
        array $options = []
    ): string
    {
        $containerInnerHtml = '<!-- <container ' . $container->getId() . '> -->';
        foreach ($renderTags as $row) {
            $containerInnerHtml .= "\n<div class=\"row\">\n";
            if (is_array($row)) {
                foreach ($row as $block) {
                    $containerInnerHtml .= $block;
                }
            } else {
                $containerInnerHtml .= (string)$row;
            }
            $containerInnerHtml .= "\n</div>\n";
        }
        $containerInnerHtml .= '<!-- </container ' . $container->getId() . '> -->';

        return $this->wrapRenderedContainer->__invoke(
            $containerInnerHtml,
            $container
        );
    }
}
