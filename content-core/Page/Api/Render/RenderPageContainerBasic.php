<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\Page;
use Zrcms\ContentCore\Page\Model\PropertiesPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderPageContainerBasic implements RenderPageContainer
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultRenderPageContainerServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultRenderPageContainerServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultRenderPageContainerServiceName = RenderPageContainerRows::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderPageContainerServiceName = $defaultRenderPageContainerServiceName;
    }

    /**
     * @param Page|Content $pageContainer
     * @param array                                 $renderData ['render-tag' => '{html}']
     * @param array                                 $options
     *
     * @return string
     */
    public function __invoke(
        Content $pageContainer,
        array $renderData,
        array $options = []
    ): string
    {
        // Get version renderer or use default
        $renderPageContainerServiceName = $pageContainer->getProperty(
            PropertiesPage::RENDERER,
            $this->defaultRenderPageContainerServiceName
        );

        /** @var RenderPageContainer $renderPageContainerService */
        $renderPageContainerService = $this->serviceContainer->get(
            $renderPageContainerServiceName
        );

        return $renderPageContainerService->__invoke(
            $pageContainer,
            $renderData
        );
    }
}
