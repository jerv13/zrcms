<?php

namespace Zrcms\Core\BlockInstance\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\Core\Block\Api\Repository\FindBlock;
use Zrcms\Core\Block\Model\Block;
use Zrcms\Core\BlockInstance\Model\BlockInstance;

class RenderBlockInstanceBasic implements RenderBlockInstance
{
    protected $findBlock;
    protected $serviceContainer;
    protected $defaultRenderServiceName;

    /**
     * @param FindBlock          $findBlock
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultRenderServiceName
     */
    public function __construct(
        FindBlock $findBlock,
        ContainerInterface $serviceContainer,
        string $defaultRenderServiceName = RenderBlockInstanceMustache::class
    ) {
        $this->findBlock = $findBlock;
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param BlockInstance|Content $blockInstance
     * @param array                 $renderData ['templateTag' => '{html}']
     * @param array                 $options
     *
     * @return string
     */
    public function __invoke(
        Content $blockInstance,
        array $renderData,
        array $options = []
    ): string
    {
        /** @var Block $block */
        $block = $this->findBlock->__invoke($blockInstance->getBlockName());

        $renderServiceName = $block->getProperty(
            $block->getRenderer(),
            $this->defaultRenderServiceName
        );

        /** @var RenderBlockInstance $render */
        $render = $this->serviceContainer->get(
            $renderServiceName
        );

        return $render->__invoke(
            $blockInstance,
            $renderData
        );
    }
}
