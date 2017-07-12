<?php

namespace Zrcms\Core\Layout\Api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Container\Api\BuildContainerUri;
use Zrcms\Core\Container\Api\FindContainerPathsByHtml;
use Zrcms\Core\Container\Api\FindContainers;
use Zrcms\Core\Container\Api\GetContainerRenderData;
use Zrcms\Core\Container\Api\RenderContainer;
use Zrcms\Core\Container\Model\Container;
use Zrcms\Core\Container\Model\ContainerRenderProperties;
use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\Layout\Model\LayoutProperties;
use Zrcms\Core\Page\Model\Page;
use Zrcms\Core\Page\Model\PageRenderNamespace;
use Zrcms\Core\Page\Model\PageRenderProperties;
use Zrcms\Core\Uri\Api\ParseCmsUri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutRenderDataBasic implements GetLayoutRenderData
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
     * @var GetContainerRenderData
     */
    protected $getContainerRenderData;

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
     * @param                        $serviceContainer
     * @param FindContainers         $findContainers
     * @param GetContainerRenderData $getContainerRenderData
     * @param BuildContainerUri      $buildContainerUri
     * @param ParseCmsUri            $parseCmsUri
     * @param RenderLayout           $defaultRenderServiceName
     */
    public function __construct(
        $serviceContainer,
        FindContainers $findContainers,
        GetContainerRenderData $getContainerRenderData,
        BuildContainerUri $buildContainerUri,
        ParseCmsUri $parseCmsUri,
        RenderLayout $defaultRenderServiceName = RenderLayoutMustache::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findContainers = $findContainers;
        $this->getContainerRenderData = $getContainerRenderData;
        $this->buildContainerUri = $buildContainerUri;
        $this->parseCmsUri = $parseCmsUri;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param Layout                 $layout
     * @param Page                   $page
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        Layout $layout,
        Page $page,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
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

        $containerHtml = [];

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
            $containerRenderData = $this->getContainerRenderData->__invoke(
                $container,
                $request
            );

            $containerUri = $this->parseCmsUri->__invoke(
                $container->getUri()
            );

            $containerHtml[$containerUri->getPath()] = $renderContainer->__invoke(
                $container,
                $containerRenderData
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

        $containerRenderData = $this->getContainerRenderData->__invoke(
            $page,
            $request
        );

        $containerHtml[PageRenderProperties::NAME] = $renderContainer->__invoke(
            $page,
            $containerRenderData
        );

        return [
            ContainerRenderProperties::NAMESPACE => $containerHtml
        ];
    }

}
