<?php

namespace Zrcms\Core\Container\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\BlockInstance\Api\FindBlockInstancesByContainer;
use Zrcms\Core\BlockInstance\Api\RenderBlockInstance;
use Zrcms\Core\BlockInstance\Api\WrapRenderedBlockInstance;
use Zrcms\Core\BlockInstance\Model\BlockInstance;
use Zrcms\Core\BlockInstance\Model\BlockInstanceProperties;
use Zrcms\Core\Container\Model\Container;
use Zrcms\Core\Page\Model\Page;

class RenderContainerBasic implements RenderContainer
{
    /**
     * @var FindBlockInstancesByContainer
     */
    protected $findBlockInstancesByContainer;

    protected $renderBlockInstance;

    protected $wrapRenderedBlockInstance;

    /**
     * @param ContainerInterface $serviceContainer
     * @param FindBlockInstancesByContainer $findBlockInstancesByContainer
     */
    public function __construct(
        FindBlockInstancesByContainer $findBlockInstancesByContainer,
        RenderBlockInstance $renderBlockInstance,
        WrapRenderedBlockInstance $wrapRenderedBlockInstance
    ) {
        $this->findBlockInstancesByContainer = $findBlockInstancesByContainer;
        $this->renderBlockInstance = $renderBlockInstance;
        $this->wrapRenderedBlockInstance = $wrapRenderedBlockInstance;
    }

    /**
     * @param Container $container
     * @param BlockInstances $blockInstances
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public function __invoke(
        Container $container,
        BlockInstances $blockInstances,
        array $options = []
    ): string {
//        $blockInstancesWithoutData = $this->findBlockInstancesByContainer->__invoke($container);
//
//        $blockInstances = $blockInstanceDataProviderCaller->__invoke($request, $blockInstancesWithoutData);//@TODO I take request

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
                throw new \Exception('Block instance has duplicate "renderOrder" in its row. '
                    . 'BlockInstance->Uid: ' . $blockInstance->getUid());
            }

            $blockInnerHtml = $this->renderBlockInstance->__invoke();
            $blockOuterHtml = $this->wrapRenderedBlockInstance->__invoke($blockInnerHtml, $blockInstance);

            $renderedBlocks[$rowNumber][$renderOrder] = $blockOuterHtml;
        }

        $containerInnerHtml = '';
        foreach ($renderedBlocks as $row) {
            $containerInnerHtml .= '<div class="row">';
            foreach ($row as $block) {
                $containerInnerHtml .= $block;
            }
            $containerInnerHtml .= '</div>';
        }

        $isPageContainer = $container instanceof Page;

        return '<div class="container-fluid rcmContainer" '
            . 'data-containerid="' . $container->getUid() . '" '
            . ($isPageContainer ? 'data-ispagecontainer="Y" ' : '')
//            . 'data-containerrevision="????" '
//            . 'id="' . $container->getUid()
            . '">'
            . $containerInnerHtml
            . '</div>';
    }
}
