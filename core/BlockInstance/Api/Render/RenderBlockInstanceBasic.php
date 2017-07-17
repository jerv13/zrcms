<?php

namespace Zrcms\Core\BlockInstance\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Block\Api\Repository\FindBlock;
use Zrcms\Core\Block\Model\Block;
use Zrcms\Core\Block\Model\BlockProperties;
use Zrcms\Core\BlockInstance\Model\BlockInstance;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockInstanceBasic implements RenderBlockInstance
{
    protected $findBlock;
    protected $serviceContainer;
    protected $defaultRenderServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param FindBlock          $findBlock
     * @param string             $defaultRenderServiceName
     */
    public function __construct(
        $serviceContainer,
        FindBlock $findBlock,
        string $defaultRenderServiceName = RenderBlockInstanceMustache::class
    ) {
        $this->findBlock = $findBlock;
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param BlockInstance|Content  $blockInstance
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string
     */
    public function __invoke(
        Content $blockInstance,
        ServerRequestInterface $request,
        array $options = []
    ): string
    {
        /** @var Block $block */
        $block = $this->findBlock->__invoke(
            $blockInstance->getBlockName()
        );

        $renderServiceName = $block->getProperty(
            BlockProperties::RENDERER,
            $this->defaultRenderServiceName
        );

        /** @var RenderBlockInstance $render */
        $renderContent = $this->serviceContainer->get(
            $renderServiceName
        );

        return $renderContent->__invoke(
            $blockInstance,
            $request,
            $options
        );
    }
}
