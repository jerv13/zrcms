<?php

namespace Zrcms\Core\Container\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\BlockInstance\Api\FindBlockInstancesByContainer;
use Zrcms\Core\BlockInstance\Api\RenderBlockInstance;
use Zrcms\Core\BlockInstance\Api\WrapRenderedBlockInstance;
use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Zrcms\Core\BlockInstance\Model\BlockInstanceProperties;
use Zrcms\Core\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerRenderData
{
    /**
     * @var FindBlockInstancesByContainer
     */
    protected $findBlockInstancesByContainer;

    protected $renderBlockInstance;

    protected $wrapRenderedBlockInstance;

    protected $wrapRenderedContainer;

    /**
     * @param FindBlockInstancesByContainer $findBlockInstancesByContainer
     * @param RenderBlockInstance           $renderBlockInstance
     * @param WrapRenderedBlockInstance     $wrapRenderedBlockInstance
     * @param WrapRenderedContainer         $wrapRenderedContainer
     */
    public function __construct(
        FindBlockInstancesByContainer $findBlockInstancesByContainer,
        RenderBlockInstance $renderBlockInstance,
        WrapRenderedBlockInstance $wrapRenderedBlockInstance,
        WrapRenderedContainer $wrapRenderedContainer,
        GetBlockInstanceWithData $getBlockInstanceWithData
    ) {
        $this->findBlockInstancesByContainer = $findBlockInstancesByContainer;
        $this->renderBlockInstance = $renderBlockInstance;
        $this->wrapRenderedBlockInstance = $wrapRenderedBlockInstance;
        $this->wrapRenderedContainer = $wrapRenderedContainer;
        $this->getBlockInstanceWithData = $getBlockInstanceWithData;
    }

    public function __invoke(
        Container $container,
        ServerRequestInterface $request,
        array $options = []
    ): string
    {
        $blockInstancesWithoutData = $this->findBlockInstancesByContainer->__invoke($container);

        $blockInstances = $this->getBlockInstanceWithData->__invoke(
            $blockInstancesWithoutData,
            $request
        );

        $renderedBlocks = []; //row -> renderOrder -> renderedBlockHtml

        /**
         * @var BlockInstance $blockInstance
         */
        foreach ($blockInstances as $blockInstance) {
            $rowNumber = $blockInstance->getLayoutProperty(BlockInstanceProperties::KEY_ROW_NUMBER);
            $renderOrder = $blockInstance->getLayoutProperty(BlockInstanceProperties::KEY_RENDER_ORDER);

            if (!array_key_exists($rowNumber, $renderedBlocks)) {
                $renderedBlocks[$rowNumber] = [];
            }

            if (array_key_exists($renderOrder, $renderedBlocks[$rowNumber])) {
                throw new \Exception(
                    'Block instance has duplicate "renderOrder" in its row. '
                    . 'BlockInstance->Uid: ' . $blockInstance->getUid()
                );
            }

            $blockInnerHtml = $this->renderBlockInstance->__invoke(
                $blockInstance
            );

            $blockOuterHtml = $this->wrapRenderedBlockInstance->__invoke(
                $blockInnerHtml,
                $blockInstance
            );

            $renderedBlocks[$rowNumber][$renderOrder] = $blockOuterHtml;
        }

        return $renderedBlocks;
    }
}
