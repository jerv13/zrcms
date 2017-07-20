<?php

namespace Zrcms\Core\Container\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Block\Api\Render\GetBlockRevisionRenderData;
use Zrcms\Core\Block\Api\Render\RenderBlockRevision;
use Zrcms\Core\Block\Api\Repository\FindBlockRevisionsBy;
use Zrcms\Core\Block\Api\WrapRenderedBlockRevision;
use Zrcms\Core\Block\Model\BlockRevision;
use Zrcms\Core\Block\Model\BlockRevisionProperties;
use Zrcms\Core\Container\Api\WrapRenderedContainer;
use Zrcms\Core\Container\Model\ContainerRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerRevisionRenderDataBlockRevisions implements GetContainerRevisionRenderData
{
    /**
     * @var FindBlockRevisionsBy
     */
    protected $findBlockRevisionsBy;

    /**
     * @var RenderBlockRevision
     */
    protected $renderBlockRevision;

    /**
     * @var GetBlockRevisionRenderData
     */
    protected $getBlockRevisionRenderData;

    /**
     * @var WrapRenderedBlockRevision
     */
    protected $wrapRenderedBlockRevision;

    /**
     * @var WrapRenderedContainer
     */
    protected $wrapRenderedContainer;

    /**
     * @param FindBlockRevisionsBy       $findBlockRevisionsBy
     * @param RenderBlockRevision        $renderBlockRevision
     * @param GetBlockRevisionRenderData $getBlockRevisionRenderData
     * @param WrapRenderedBlockRevision  $wrapRenderedBlockRevision
     * @param WrapRenderedContainer      $wrapRenderedContainer
     */
    public function __construct(
        FindBlockRevisionsBy $findBlockRevisionsBy,
        RenderBlockRevision $renderBlockRevision,
        GetBlockRevisionRenderData $getBlockRevisionRenderData,
        WrapRenderedBlockRevision $wrapRenderedBlockRevision,
        WrapRenderedContainer $wrapRenderedContainer
    ) {
        $this->findBlockRevisionsBy = $findBlockRevisionsBy;
        $this->renderBlockRevision = $renderBlockRevision;
        $this->getBlockRevisionRenderData = $getBlockRevisionRenderData;
        $this->wrapRenderedBlockRevision = $wrapRenderedBlockRevision;
        $this->wrapRenderedContainer = $wrapRenderedContainer;
    }

    /**
     * @param ContainerRevision|ContentRevision $containerRevision
     * @param ServerRequestInterface            $request
     * @param array                             $options
     *
     * @return array ['templateTag' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        ContentRevision $containerRevision,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $renderedData = []; //row -> renderOrder -> renderedBlockHtml

        $blockRevisions = $this->findBlockRevisionsBy->__invoke(
            [
                BlockRevisionProperties::CONTAINER_ID => $containerRevision->getId()
            ]
        );

        /** @var BlockRevision $blockRevision */
        foreach ($blockRevisions as $blockRevision) {

            $rowNumber = $blockRevision->getRequiredLayoutProperty(
                BlockRevisionProperties::LAYOUT_PROPERTIES_ROW_NUMBER
            );
            $renderOrder = $blockRevision->getRequiredLayoutProperty(
                BlockRevisionProperties::LAYOUT_PROPERTIES_RENDER_ORDER
            );

            if (!array_key_exists($rowNumber, $renderedData)) {
                $renderedData[$rowNumber] = [];
            }

            if (array_key_exists($renderOrder, $renderedData[$rowNumber])) {
                throw new \Exception(
                    'Block instance has duplicate "renderOrder" in its row. '
                    . 'BlockRevision->Uid: ' . $blockRevision->getId()
                );
            }

            $blockRevisionRenderData = $this->getBlockRevisionRenderData->__invoke(
                $blockRevision,
                $request
            );

            $blockRevisionInnerHtml = $this->renderBlockRevision->__invoke(
                $blockRevision,
                $blockRevisionRenderData
            );

            $blockRevisionOuterHtml = $this->wrapRenderedBlockRevision->__invoke(
                $blockRevisionInnerHtml,
                $blockRevision
            );

            $renderedData[$rowNumber][$renderOrder] = $blockRevisionOuterHtml;
        }

        return $renderedData;
    }
}
