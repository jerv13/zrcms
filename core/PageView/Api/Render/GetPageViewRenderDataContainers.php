<?php

namespace Zrcms\Core\PageView\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\Content;
use Zrcms\ContentResourceUri\Api\ParseCmsUri;
use Zrcms\Core\Container\Api\BuildContainerUri;
use Zrcms\Core\Container\Api\Render\GetContainerRenderData;
use Zrcms\Core\Container\Api\Render\RenderContainerCmsResource;
use Zrcms\Core\Container\Api\Repository\FindContainerCmsResourceByUris;
use Zrcms\Core\Container\Model\Container;
use Zrcms\Core\Container\Model\ContainerProperties;
use Zrcms\Core\Page\Api\BuildPageUri;
use Zrcms\Core\PageView\Model\PageView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageViewRenderDataContainers implements GetPageViewRenderData
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var FindContainerCmsResourceByUris
     */
    protected $findContainerCmsResourceByUris;

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
     * @param ContainerInterface             $serviceContainer
     * @param FindContainerCmsResourceByUris $findContainerCmsResourceByUris
     * @param GetContainerRenderData         $getContainerRenderData
     * @param BuildContainerUri              $buildContainerUri
     * @param BuildPageUri                   $buildPageUri
     * @param ParseCmsUri                    $parseCmsUri
     */
    public function __construct(
        $serviceContainer,
        FindContainerCmsResourceByUris $findContainerCmsResourceByUris,
        GetContainerRenderData $getContainerRenderData,
        BuildContainerUri $buildContainerUri,
        BuildPageUri $buildPageUri,
        ParseCmsUri $parseCmsUri
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findContainerCmsResourceByUris = $findContainerCmsResourceByUris;
        $this->getContainerRenderData = $getContainerRenderData;
        $this->buildContainerUri = $buildContainerUri;
        $this->parseCmsUri = $parseCmsUri;
    }

    /**
     * @param PageView|Content       $pageView
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $pageView,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $pageViewRenderData = [];

        $containerNs = ContainerProperties::RENDER_TAG;

        $pageViewRenderData[$containerNs] = $this->getContainersRenderData(
            $pageView,
            $request
        );

        return $pageViewRenderData;
    }

    /**
     * @param array $layoutTags
     *
     * @return array
     */
    protected function findContainerPaths(
        array $layoutTags
    ) {
        $paths = [];
        foreach ($layoutTags as $layoutTag) {
            $path = $this->getPath($layoutTag);
            if ($path !== null) {
                $paths[] = $layoutTag;
            }
        }

        return $paths;
    }

    /**
     * @todo NOTE: this will only work with tags like container.{path}
     * @todo Not with container.something.{path}
     *
     * @param string $layoutTag
     *
     * @return bool
     */
    protected function getPath(string $layoutTag)
    {
        $hasTag = (0 === strpos($layoutTag, ContainerProperties::RENDER_TAG));

        if (!$hasTag) {
            return null;
        }

        $parts = explode('.', $layoutTag);

        if (count($parts) !== 2) {
            // @todo error??
            return null;
        }

        return $parts[1];
    }

    /**
     * @param PageView               $pageView
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    protected function getContainersRenderData(
        PageView $pageView,
        ServerRequestInterface $request
    ) {
        $siteCmsResource = $pageView->getSiteCmsResource();
        $site = $siteCmsResource->getContent();

        $layoutTags = $pageView->getLayoutTags();

        $containerPaths = $this->findContainerPaths(
            $layoutTags
        );

        $containerUris = [];

        foreach ($containerPaths as $containerPath) {
            $containerUris[] = $this->buildContainerUri->__invoke(
                $site->getId(),
                $containerPath
            );
        }

        $containerCmsResources = $this->findContainerCmsResourceByUris->__invoke(
            $containerUris
        );

        $renderData = [];

        /** @var CmsResource $containerCmsResource */
        foreach ($containerCmsResources as $containerCmsResource) {
            $containerUri = $this->parseCmsUri->__invoke(
                $containerCmsResource->getUri()
            );

            /** @var Container $container */
            $container = $containerCmsResource->getContent();

            $renderData[$containerUri->getPath()] = $this->renderContainer(
                $container,
                $request
            );
        }

        return $renderData;
    }

    /**
     * @param Container              $container
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    protected function renderContainer(
        Container $container,
        ServerRequestInterface $request
    ) {
        $renderContainerServiceName = $container->getProperty(
            ContainerProperties::RENDERER,
            RenderContainerCmsResource::class
        );

        /** @var RenderContainerCmsResource $renderContainerCmsResource */
        $renderContainerCmsResource = $this->serviceContainer->get(
            $renderContainerServiceName
        );

        $containerRenderData = $this->getContainerRenderData->__invoke(
            $container,
            $request
        );

        return $renderContainerCmsResource->__invoke(
            $container,
            $containerRenderData
        );
    }
}
