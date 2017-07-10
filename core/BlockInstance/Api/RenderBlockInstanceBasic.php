<?php

namespace Zrcms\Core\BlockInstance\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Block\Api\FindBlock;
use Zrcms\Core\Block\Model\BlockProperties;
use Zrcms\Core\BlockInstance\Model\BlockInstance;

class RenderBlockInstanceBasic implements RenderBlockInstance
{
    protected $findBlock;
    protected $serviceContainer;

    public function __construct(
        FindBlock $findBlock,
        ContainerInterface $serviceContainer,
        $defaultRenderer = RenderBlockInstanceMustache::class
    ) {
        $this->findBlock = $findBlock;
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param BlockInstance $blockInstance
     * @param array $options
     *
     * @return string
     */
    public function __invoke(
        BlockInstance $blockInstance,
        array $options = []
    ): string {

        $block = $this->findBlock->__invoke($blockInstance->getBlockName());

        $renderServiceName = $block->getProperty(
            $block->getRenderer(),
            $this->defaultRenderServiceName
        );

        /** @var RenderLayout $render */
        $render = $this->serviceContainer->get(
            $renderServiceName
        );

        return $render->__invoke(
            $blockInstance
        );
    }
}
