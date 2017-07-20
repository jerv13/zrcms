<?php

namespace Zrcms\Core\Container\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Api\Render\RenderContentRevision;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Container\Model\ContainerRevision;
use Zrcms\Core\Container\Model\ContainerRevisionProperties;

class RenderContainerRevisionBasic implements RenderContentRevision
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultRenderContainerRevisionServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultRenderContainerRevisionServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultRenderContainerRevisionServiceName = RenderContainerRevisionRows::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderContainerRevisionServiceName = $defaultRenderContainerRevisionServiceName;
    }

    /**
     * @param ContainerRevision|ContentRevision $ContainerRevision
     * @param array                             $renderData ['templateTag' => '{html}']
     * @param array                             $options
     *
     * @return string
     */
    public function __invoke(
        ContentRevision $ContainerRevision,
        array $renderData,
        array $options = []
    ): string
    {
        // Get revision renderer or use default
        $renderContainerRevisionServiceName = $ContainerRevision->getProperty(
            ContainerRevisionProperties::RENDERER,
            $this->defaultRenderContainerRevisionServiceName
        );

        /** @var RenderContainerRevision $renderContainerRevisionService */
        $renderContainerRevisionService = $this->serviceContainer->get(
            $renderContainerRevisionServiceName
        );

        return $renderContainerRevisionService->__invoke(
            $ContainerRevision,
            $renderData
        );
    }
}
