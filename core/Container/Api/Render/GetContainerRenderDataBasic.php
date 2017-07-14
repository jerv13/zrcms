<?php

namespace Zrcms\Core\Container\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\BlockInstance\Api\Render\GetBlockInstanceRenderData;
use Zrcms\Core\BlockInstance\Api\Render\RenderBlockInstance;
use Zrcms\Core\BlockInstance\Api\WrapRenderedBlockInstance;
use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Zrcms\Core\BlockInstance\Model\BlockInstanceProperties;
use Zrcms\Core\Container\Api\WrapRenderedContainer;
use Zrcms\Core\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerRenderDataBasic implements GetContainerRenderData
{
    /**
     * @var RenderBlockInstance
     */
    protected $renderBlockInstance;

    /**
     * @var WrapRenderedBlockInstance
     */
    protected $wrapRenderedBlockInstance;

    /**
     * @var WrapRenderedContainer
     */
    protected $wrapRenderedContainer;

    /**
     * @var GetBlockInstanceRenderData
     */
    protected $getBlockInstanceRenderData;

    /**
     * @param RenderBlockInstance        $renderBlockInstance
     * @param WrapRenderedBlockInstance  $wrapRenderedBlockInstance
     * @param WrapRenderedContainer      $wrapRenderedContainer
     * @param GetBlockInstanceRenderData $getBlockInstanceRenderData
     */
    public function __construct(
        RenderBlockInstance $renderBlockInstance,
        WrapRenderedBlockInstance $wrapRenderedBlockInstance,
        WrapRenderedContainer $wrapRenderedContainer,
        GetBlockInstanceRenderData $getBlockInstanceRenderData
    ) {
        $this->renderBlockInstance = $renderBlockInstance;
        $this->wrapRenderedBlockInstance = $wrapRenderedBlockInstance;
        $this->wrapRenderedContainer = $wrapRenderedContainer;
        $this->getBlockInstanceRenderData = $getBlockInstanceRenderData;
    }

    /**
     * @param Content|Container      $container
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
        $renderedBlockInstances = []; //row -> renderOrder -> renderedBlockHtml

        $blockInstances = $container->getBlockInstances();

        /** @var BlockInstance $blockInstance */
        foreach ($blockInstances as $blockInstance) {

            $rowNumber = $blockInstance->getRequiredLayoutProperty(
                BlockInstanceProperties::LAYOUT_PROPERTIES_ROW_NUMBER
            );
            $renderOrder = $blockInstance->getRequiredLayoutProperty(
                BlockInstanceProperties::LAYOUT_PROPERTIES_RENDER_ORDER
            );

            if (!array_key_exists($rowNumber, $renderedBlockInstances)) {
                $renderedBlockInstances[$rowNumber] = [];
            }

            if (array_key_exists($renderOrder, $renderedBlockInstances[$rowNumber])) {
                throw new \Exception(
                    'Block instance has duplicate "renderOrder" in its row. '
                    . 'BlockInstance->Uid: ' . $blockInstance->getId()
                );
            }

            $blockInstanceInnerHtml = $this->renderBlockInstance->__invoke(
                $blockInstance,
                $request
            );

            $blockInstanceOuterHtml = $this->wrapRenderedBlockInstance->__invoke(
                $blockInstanceInnerHtml,
                $blockInstance
            );

            $renderedBlockInstances[$rowNumber][$renderOrder] = $blockInstanceOuterHtml;
        }

        return $renderedBlockInstances;
    }
}
