<?php

namespace Zrcms\CoreContainer\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTags;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\CoreBlock\Api\Render\WrapRenderedBlockVersion;
use Zrcms\CoreBlock\Fields\FieldsBlock;
use Zrcms\CoreBlock\Model\Block;
use Zrcms\CoreContainer\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerRenderTagsBlocks implements GetContainerRenderTags
{
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
     * @param RenderBlock              $renderBlock
     * @param GetBlockRenderTags       $getBlockRenderTags
     * @param WrapRenderedBlockVersion $wrapRenderedBlockVersion
     * @param WrapRenderedContainer    $wrapRenderedContainer
     */
    public function __construct(
        RenderBlock $renderBlock,
        GetBlockRenderTags $getBlockRenderTags,
        WrapRenderedBlockVersion $wrapRenderedBlockVersion,
        WrapRenderedContainer $wrapRenderedContainer
    ) {
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
    ): array {
        $renderedData = []; //row -> renderOrder -> renderedBlockHtml

        $blocks = $container->getBlockVersions();

        $blocks = $this->sort($blocks);

        /** @var Block $block */
        foreach ($blocks as $block) {
            $rowNumber = $block->getRequiredLayoutProperty(
                FieldsBlock::LAYOUT_PROPERTIES_ROW_NUMBER
            );

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

            $renderedData[$rowNumber][] = $blockOuterHtml;
        }

        return $renderedData;
    }

    /**
     * @todo There are faster ways to sort
     *
     * @param Block[] $blocks
     *
     * @return array
     */
    protected function sort(array $blocks)
    {
        $rowGroups = $this->groupRows($blocks);

        return $this->sortRows($rowGroups);
    }

    /**
     * @param Block[] $blocks
     *
     * @return array
     */
    protected function groupRows(array $blocks)
    {
        $rowGroups = [];
        foreach ($blocks as $block) {
            $rowNumber = $block->getRequiredLayoutProperty(
                FieldsBlock::LAYOUT_PROPERTIES_ROW_NUMBER
            );
            if (!array_key_exists($rowNumber, $rowGroups)) {
                $rowGroups[$rowNumber] = [];
            }

            $rowGroups[$rowNumber][] = $block;
        }

        return $rowGroups;
    }

    /**
     * @param $rowGroups
     *
     * @return array
     */
    protected function sortRows(array $rowGroups)
    {
        $blocks = [];

        foreach ($rowGroups as $renderRow => $rowGroup) {
            $blocks = $this->addSortedByOrder($rowGroup, $blocks);
        }

        return $blocks;
    }

    /**
     * @param array $rowGroup
     * @param array $blocks
     *
     * @return array
     */
    protected function addSortedByOrder(array $rowGroup, array $blocks)
    {
        usort($rowGroup, [$this, 'sortOrder']);

        foreach ($rowGroup as $block) {
            $blocks[] = $block;
        }

        return $blocks;
    }

    /**
     * @param Block $a
     * @param Block $b
     *
     * @return int
     */
    protected function sortOrder(Block $a, Block $b)
    {
        $renderOrderA = $a->getRequiredLayoutProperty(
            FieldsBlock::LAYOUT_PROPERTIES_RENDER_ORDER
        );

        $renderOrderB = $b->getRequiredLayoutProperty(
            FieldsBlock::LAYOUT_PROPERTIES_RENDER_ORDER
        );

        return ($renderOrderA < $renderOrderB) ? -1 : 1;
    }
}
