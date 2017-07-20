<?php

namespace Zrcms\Core\Page\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Model\ContentRevision;
use Zrcms\Core\Page\Model\PageContainerRevision;
use Zrcms\Core\Page\Model\PageContainerRevisionProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderPageContainerRevisionBasic implements RenderPageContainerRevision
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultRenderPageContainerRevisionServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultRenderPageContainerRevisionServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultRenderPageContainerRevisionServiceName = RenderPageContainerRevisionRows::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderPageContainerRevisionServiceName = $defaultRenderPageContainerRevisionServiceName;
    }

    /**
     * @param PageContainerRevision|ContentRevision $pageContainerRevision
     * @param array                                 $renderData ['templateTag' => '{html}']
     * @param array                                 $options
     *
     * @return string
     */
    public function __invoke(
        ContentRevision $pageContainerRevision,
        array $renderData,
        array $options = []
    ): string
    {
        // Get revision renderer or use default
        $renderPageContainerRevisionServiceName = $pageContainerRevision->getProperty(
            PageContainerRevisionProperties::RENDERER,
            $this->defaultRenderPageContainerRevisionServiceName
        );

        /** @var RenderPageContainerRevision $renderPageContainerRevisionService */
        $renderPageContainerRevisionService = $this->serviceContainer->get(
            $renderPageContainerRevisionServiceName
        );

        return $renderPageContainerRevisionService->__invoke(
            $pageContainerRevision,
            $renderData
        );
    }
}
