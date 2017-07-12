<?php

namespace Zrcms\Core\Layout\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Container\Api\BuildContainerUri;
use Zrcms\Core\Container\Api\FindContainerPathsByHtml;
use Zrcms\Core\Container\Api\FindContainers;
use Zrcms\Core\Container\Api\RenderContainer;
use Zrcms\Core\Container\Model\Container;
use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\Layout\Model\LayoutProperties;
use Zrcms\Core\Page\Model\Page;
use Zrcms\Core\RenderData\Model\RenderDataCollection;
use Zrcms\Core\Uri\Api\ParseCmsUri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutRenderDataBasic
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var FindContainers
     */
    protected $findContainers;

    /**
     * @var BuildContainerUri
     */
    protected $buildContainerUri;

    /**
     * @var ParseCmsUri
     */
    protected $parseCmsUri;

    /**
     * @var RenderLayout
     */
    protected $defaultRenderServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param FindContainers     $findContainers
     * @param BuildContainerUri  $buildContainerUri
     * @param ParseCmsUri        $parseCmsUri
     * @param RenderLayout       $defaultRenderServiceName
     */
    public function __construct(
        $serviceContainer,
        FindContainers $findContainers,
        BuildContainerUri $buildContainerUri,
        ParseCmsUri $parseCmsUri,
        RenderLayout $defaultRenderServiceName = RenderLayoutMustache::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findContainers = $findContainers;
        $this->buildContainerUri = $buildContainerUri;
        $this->parseCmsUri = $parseCmsUri;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param Layout $layout
     * @param Page   $page
     * @param array  $options
     *
     * @return RenderDataCollection
     */
    public function __invoke(
        Layout $layout,
        Page $page,
        array $options = []
    ): RenderDataCollection {
        $findContainerPathsByHtmlServiceName = $layout->getProperty(
            LayoutProperties::KEY_CONTAINER_PATHS_SERVICE,
            FindContainerPathsByHtml::class
        );

        /** @var FindContainerPathsByHtml $findContainerPathsByLayout */
        $findContainerPathsByHtml = $this->serviceContainer->get(
            $findContainerPathsByHtmlServiceName
        );

        $containerPaths = $findContainerPathsByHtml->__invoke(
            $layout->getHtml()
        );

        $pageUri = $this->parseCmsUri->__invoke(
            $page->getUri()
        );

        $containerUris = [];

        foreach ($containerPaths as $containerPath) {
            $containerUris[] = $this->buildContainerUri->__invoke(
                $pageUri->getSiteId(),
                $containerPath
            );
        }

        $containers = $this->findContainers->__invoke(
            $containerUris
        );

        $containerRenderData = new RenderDataCollectionBasic();

        /** @var Container $container */
        foreach ($containers as $container) {

            $renderContainerServiceName = $container->getProperty(
                LayoutProperties::KEY_RENDER,
                RenderContainer::class
            );

            /** @var RenderContainer $renderContainer */
            $renderContainer = $this->serviceContainer->get(
                $renderContainerServiceName
            );

            $containerUri = $this->parseCmsUri->__invoke(
                $container->getUri()
            );

            $containerHtml['container:' . $containerUri->getPath()] = $renderContainer->__invoke(
                $container
            );
        }

        $renderContainerServiceName = $page->getProperty(
            LayoutProperties::KEY_RENDER,
            RenderContainer::class
        );

        /** @var RenderContainer $renderContainer */
        $renderContainer = $this->serviceContainer->get(
            $renderContainerServiceName
        );

        $containerHtml['container:{page}'] = $renderContainer->__invoke(
            $page
        );

        return $containerHtml;
    }

}
