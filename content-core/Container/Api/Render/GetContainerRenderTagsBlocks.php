<?php

namespace Zrcms\ContentCore\Container\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Block\Api\Render\GetBlockRenderTags;
use Zrcms\ContentCore\Block\Api\Render\RenderBlock;
use Zrcms\ContentCore\Block\Api\Repository\FindBlockVersionsByContainer;
use Zrcms\ContentCore\Block\Api\WrapRenderedBlockVersion;
use Zrcms\ContentCore\Block\Model\Block;
use Zrcms\ContentCore\Block\Model\PropertiesBlock;
use Zrcms\ContentCore\Container\Api\WrapRenderedContainer;
use Zrcms\ContentCore\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerRenderTagsBlocks implements GetContainerRenderTags
{
    /**
     * @var FindBlockVersionsByContainer
     */
    protected $findBlockVersionsByContainer;

    /**
     * @var RenderBlock
     */
    protected $renderBlock;

    /**
     * @var GetBlockRenderTags
     */
    protected $getBlockRenderTags;

    /**
     * @var WrapRenderedBlockVersion
     */
    protected $wrapRenderedBlockVersion;

    /**
     * @var WrapRenderedContainer
     */
    protected $wrapRenderedContainer;

    /**
     * @param FindBlockVersionsByContainer $findBlockVersionsByContainer
     * @param RenderBlock                  $renderBlock
     * @param GetBlockRenderTags           $getBlockRenderTags
     * @param WrapRenderedBlockVersion     $wrapRenderedBlockVersion
     * @param WrapRenderedContainer        $wrapRenderedContainer
     */
    public function __construct(
        FindBlockVersionsByContainer $findBlockVersionsByContainer,
        RenderBlock $renderBlock,
        GetBlockRenderTags $getBlockRenderTags,
        WrapRenderedBlockVersion $wrapRenderedBlockVersion,
        WrapRenderedContainer $wrapRenderedContainer
    ) {
        $this->findBlockVersionsByContainer = $findBlockVersionsByContainer;
        $this->renderBlock = $renderBlock;
        $this->getBlockRenderTags = $getBlockRenderTags;
        $this->wrapRenderedBlockVersion = $wrapRenderedBlockVersion;
        $this->wrapRenderedContainer = $wrapRenderedContainer;
    }

    /**
     * @param Container|Content      $container
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $container,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $renderedData = []; //row -> renderOrder -> renderedBlockHtml

        $blocks = $this->findBlockVersionsByContainer->__invoke(
            $container
        );

        /** @var Block $block */
        foreach ($blocks as $block) {
            $rowNumber = $block->getRequiredLayoutProperty(
                PropertiesBlock::LAYOUT_PROPERTIES_ROW_NUMBER
            );
            $renderOrder = $block->getRequiredLayoutProperty(
                PropertiesBlock::LAYOUT_PROPERTIES_RENDER_ORDER
            );

            if (!array_key_exists($rowNumber, $renderedData)) {
                $renderedData[$rowNumber] = [];
            }

            if (array_key_exists($renderOrder, $renderedData[$rowNumber])) {
                throw new \Exception(
                    'Block instance has duplicate "renderOrder" in its row. '
                    . 'Block->Uid: ' . $block->getId()
                );
            }

            $blockRenderTags = $this->getBlockRenderTags->__invoke(
                $block,
                $request
            );

            $blockInnerHtml = $this->renderBlock->__invoke(
                $block,
                $blockRenderTags
            );

            $blockOuterHtml = $this->wrapRenderedBlockVersion->__invoke(
                $blockInnerHtml,
                $block
            );

            $renderedData[$rowNumber][$renderOrder] = $blockOuterHtml;
        }

        return $renderedData;
    }
}
