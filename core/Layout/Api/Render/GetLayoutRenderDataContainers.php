<?php

namespace Zrcms\Core\Layout\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentVersionControl\Model\Content;
use Zrcms\Core\Container\Api\BuildContainerUri;
use Zrcms\Core\Container\Api\Render\GetContainerRenderData;
use Zrcms\Core\Container\Api\Render\RenderContainer;
use Zrcms\Core\Container\Api\Repository\FindContainerPathsByHtml;
use Zrcms\Core\Container\Api\Repository\FindContainersByUris;
use Zrcms\Core\Container\Model\Container;
use Zrcms\Core\Container\Model\ContainerRenderProperties;
use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\Layout\Model\LayoutProperties;
use Zrcms\Core\Page\Api\BuildPageUri;
use Zrcms\Core\Page\Api\Repository\FindPage;
use Zrcms\Core\Page\Exception\PageNotFoundException;
use Zrcms\Core\Page\Model\Page;
use Zrcms\Core\Page\Model\PageRenderProperties;
use Zrcms\Core\Site\Api\Repository\FindSite;
use Zrcms\Core\Site\Exception\SiteNotFoundException;
use Zrcms\Core\Site\Model\Site;
use Zrcms\Core\Uri\Api\ParseCmsUri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetLayoutRenderDataContainers implements GetLayoutRenderData
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var FindSite
     */
    protected $findSite;

    /**
     * @var FindPage
     */
    protected $findPage;

    /**
     * @var FindContainersByUris
     */
    protected $findContainersByUris;

    /**
     * @var GetContainerRenderData
     */
    protected $getContainerRenderData;

    /**
     * @var BuildContainerUri
     */
    protected $buildContainerUri;

    /**
     * @var BuildPageUri
     */
    protected $buildPageUri;

    /**
     * @var ParseCmsUri
     */
    protected $parseCmsUri;

    /**
     * @var string
     */
    protected $defaultRenderServiceName;

    /**
     * @param ContainerInterface     $serviceContainer
     * @param FindSite               $findSite
     * @param FindPage               $findPage
     * @param FindContainersByUris   $findContainersByUris
     * @param GetContainerRenderData $getContainerRenderData
     * @param BuildContainerUri      $buildContainerUri
     * @param BuildPageUri           $buildPageUri
     * @param ParseCmsUri            $parseCmsUri
     * @param string                 $defaultRenderServiceName
     */
    public function __construct(
        $serviceContainer,
        FindSite $findSite,
        FindPage $findPage,
        FindContainersByUris $findContainersByUris,
        GetContainerRenderData $getContainerRenderData,
        BuildContainerUri $buildContainerUri,
        BuildPageUri $buildPageUri,
        ParseCmsUri $parseCmsUri,
        string $defaultRenderServiceName = RenderLayoutMustache::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findSite = $findSite;
        $this->findPage = $findPage;
        $this->findContainersByUris = $findContainersByUris;
        $this->getContainerRenderData = $getContainerRenderData;
        $this->buildContainerUri = $buildContainerUri;
        $this->buildPageUri = $buildPageUri;
        $this->parseCmsUri = $parseCmsUri;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param Layout|Content         $layout
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $layout,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $requestUri = $request->getUri();
        $requestHost = $requestUri->getHost();
        $requestPath = $requestUri->getPath();
        /** @var Site $site */
        $site = $this->findSite->__invoke(
            $requestHost
        );

        if (empty($site)) {
            throw new SiteNotFoundException("Site ({$requestHost}) not found");
        }

        $pageUri = $this->buildPageUri->__invoke(
            $site->getId(),
            $requestPath
        );

        /** @var Page $page */
        $page = $this->findPage->__invoke($pageUri);

        if (empty($page)) {
            throw new PageNotFoundException("Page ({$requestPath}) not found");
        }

        $layoutRenderData = [];

        $containerNs = ContainerRenderProperties::NAMESPACE;

        $layoutRenderData[$containerNs] = $this->getContainersRenderData(
            $layout,
            $site,
            $request
        );

        $layoutRenderData[$containerNs][PageRenderProperties::NAME] = $this->renderContainer(
            $page,
            $request,
            LayoutProperties::KEY_RENDER
        );

        return $layoutRenderData;
    }

    /**
     * @param Layout                 $layout
     * @param Site                   $site
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    protected function getContainersRenderData(
        Layout $layout,
        Site $site,
        ServerRequestInterface $request
    ) {
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

        $containerUris = [];

        foreach ($containerPaths as $containerPath) {
            $containerUris[] = $this->buildContainerUri->__invoke(
                $site->getId(),
                $containerPath
            );
        }

        $containers = $this->findContainersByUris->__invoke(
            $containerUris
        );

        $renderData = [];

        /** @var Container $container */
        foreach ($containers as $container) {
            $containerUri = $this->parseCmsUri->__invoke(
                $container->getUri()
            );

            $renderData[$containerUri->getPath()] = $this->renderContainer(
                $container,
                $request,
                LayoutProperties::KEY_RENDER
            );
        }

        return $renderData;
    }

    /**
     * @param Container              $container
     * @param ServerRequestInterface $request
     * @param string                 $rendererPropertyName
     *
     * @return string
     */
    protected function renderContainer(
        Container $container,
        ServerRequestInterface $request,
        $rendererPropertyName = LayoutProperties::KEY_RENDER
    ) {
        $renderContainerServiceName = $container->getProperty(
            $rendererPropertyName,
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

        return $renderContainer->__invoke(
            $container,
            $containerRenderData
        );
    }

}
