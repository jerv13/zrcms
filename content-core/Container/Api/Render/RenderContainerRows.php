<?php

namespace Zrcms\ContentCore\Container\Api\Render;

use Zrcms\Content\Api\Render\RenderContent;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Block\Api\Render\RenderBlock;
use Zrcms\ContentCore\Container\Api\WrapRenderedContainer;
use Zrcms\ContentCore\Container\Model\Container;

class RenderContainerRows implements RenderContent
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
     * @param array             $renderData ['render-tag' => '{html}']
     * @param array             $options
     *
     * @return string
     */
    public function __invoke(
        Content $container,
        array $renderData,
        array $options = []
    ): string
    {
        $containerInnerHtml = '';
        foreach ($renderData as $row) {
            $containerInnerHtml .= '<div class="row">';
            foreach ($row as $block) {
                $containerInnerHtml .= $block;
            }
            $containerInnerHtml .= '</div>';
        }

        return $this->wrapRenderedContainer->__invoke(
            $containerInnerHtml,
            $container
        );
    }
}