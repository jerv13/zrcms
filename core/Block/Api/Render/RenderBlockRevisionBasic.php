<?php

namespace Zrcms\Core\Block\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Block\Api\Repository\FindBlockComponent;
use Zrcms\Core\Block\Model\BlockComponent;
use Zrcms\Core\Block\Model\BlockComponentProperties;
use Zrcms\Core\Block\Model\BlockRevision;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderBlockRevisionBasic implements RenderBlockRevision
{
    /**
     * @var FindBlockComponent
     */
    protected $findBlockComponent;

    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultRenderServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param FindBlockComponent $findBlockComponent
     * @param string             $defaultRenderServiceName
     */
    public function __construct(
        $serviceContainer,
        FindBlockComponent $findBlockComponent,
        string $defaultRenderServiceName = RenderBlockRevisionMustache::class
    ) {
        $this->findBlockComponent = $findBlockComponent;
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param BlockRevision|ContentRevision $blockRevision
     * @param array                                 $renderData ['templateTag' => '{html}']
     * @param array                                 $options
     *
     * @return string
     */
    public function __invoke(
        ContentRevision $blockRevision,
        array $renderData,
        array $options = []
    ): string
    {
        /** @var BlockComponent $blockComponent */
        $blockComponent = $this->findBlockComponent->__invoke(
            $blockRevision->getBlockComponentName()
        );

        // Get revision renderer or use default
        $renderServiceName = $blockComponent->getProperty(
            BlockComponentProperties::RENDERER,
            $this->defaultRenderServiceName
        );

        /** @var RenderBlockRevision $render */
        $renderBlockRevision = $this->serviceContainer->get(
            $renderServiceName
        );

        return $renderBlockRevision->__invoke(
            $blockRevision,
            $renderData,
            $options
        );
    }
}
