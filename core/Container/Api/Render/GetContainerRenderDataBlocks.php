<?php

namespace Zrcms\Core\Container\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Block\Api\Render\GetBlockRenderData;
use Zrcms\Core\Block\Api\Render\RenderBlock;
use Zrcms\Core\Block\Api\Repository\FindBlockVersionsBy;
use Zrcms\Core\Block\Api\WrapRenderedBlock;
use Zrcms\Core\Block\Model\Block;
use Zrcms\Core\Block\Model\PropertiesBlock;
use Zrcms\Core\Container\Api\WrapRenderedContainer;
use Zrcms\Core\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerRenderDataBlocks implements GetContainerRenderData
{
    /**
     * @var FindBlockVersionsBy
     */
    protected $findBlockVersionsBy;

    /**
     * @var RenderBlock
     */
    protected $renderBlock;

    /**
     * @var GetBlockRenderData
     */
    protected $getBlockRenderData;

    /**
     * @var WrapRenderedBlock
     */
    protected $wrapRenderedBlock;

    /**
     * @var WrapRenderedContainer
     */
    protected $wrapRenderedContainer;

    /**
     * @param FindBlockVersionsBy   $findBlockVersionsBy
     * @param RenderBlock           $renderBlock
     * @param GetBlockRenderData    $getBlockRenderData
     * @param WrapRenderedBlock     $wrapRenderedBlock
     * @param WrapRenderedContainer $wrapRenderedContainer
     */
    public function __construct(
        FindBlockVersionsBy $findBlockVersionsBy,
        RenderBlock $renderBlock,
        GetBlockRenderData $getBlockRenderData,
        WrapRenderedBlock $wrapRenderedBlock,
        WrapRenderedContainer $wrapRenderedContainer
    ) {
        $this->findBlockVersionsBy = $findBlockVersionsBy;
        $this->renderBlock = $renderBlock;
        $this->getBlockRenderData = $getBlockRenderData;
        $this->wrapRenderedBlock = $wrapRenderedBlock;
        $this->wrapRenderedContainer = $wrapRenderedContainer;
    }

    /**
     * @param Container|Content      $container
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array ['templateTag' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $container,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $renderedData = []; //row -> renderOrder -> renderedBlockHtml

        $blocks = $this->findBlockVersionsBy->__invoke(
            [
                PropertiesBlock::CONTAINER_ID => $container->getId()
            ]
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

            $blockRenderData = $this->getBlockRenderData->__invoke(
                $block,
                $request
            );

            $blockInnerHtml = $this->renderBlock->__invoke(
                $block,
                $blockRenderData
            );

            $blockOuterHtml = $this->wrapRenderedBlock->__invoke(
                $blockInnerHtml,
                $block
            );

            $renderedData[$rowNumber][$renderOrder] = $blockOuterHtml;
        }

        return $renderedData;
    }
}
