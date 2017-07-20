<?php

namespace Zrcms\Core\View\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Container\Api\Render\GetContainerRenderData;
use Zrcms\Core\Container\Api\Repository\FindContainerCmsResourceBySitePaths;
use Zrcms\Core\Container\Api\Repository\FindContainerVersion;
use Zrcms\Core\Container\Model\Container;
use Zrcms\Core\Container\Model\ContainerCmsResource;
use Zrcms\Core\Container\Model\PropertiesContainer;
use Zrcms\Core\View\Api\Repository\FindTagNamesByLayout;
use Zrcms\Core\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataContainers implements GetViewRenderData
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var FindTagNamesByLayout
     */
    protected $findTagNamesByLayout;

    /**
     * @var FindContainerCmsResourceBySitePaths
     */
    protected $findContainerCmsResourceBySitePaths;

    /**
     * @var FindContainerVersion
     */
    protected $findContainerVersion;

    /**
     * @var GetContainerRenderData
     */
    protected $getContainerRenderData;

    /**
     * @param                                     $serviceContainer
     * @param FindTagNamesByLayout                $findTagNamesByLayout
     * @param FindContainerCmsResourceBySitePaths $findContainerCmsResourceBySitePaths
     * @param FindContainerVersion                $findContainerVersion
     * @param GetContainerRenderData              $getContainerRenderData
     */
    public function __construct(
        $serviceContainer,
        FindTagNamesByLayout $findTagNamesByLayout,
        FindContainerCmsResourceBySitePaths $findContainerCmsResourceBySitePaths,
        FindContainerVersion $findContainerVersion,
        GetContainerRenderData $getContainerRenderData
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->findTagNamesByLayout = $findTagNamesByLayout;
        $this->findContainerCmsResourceBySitePaths = $findContainerCmsResourceBySitePaths;
        $this->findContainerVersion = $findContainerVersion;
        $this->getContainerRenderData = $getContainerRenderData;
    }

    /**
     * @param View|Content           $view
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $view,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $viewRenderData = [];

        $containerNs = PropertiesContainer::RENDER_TAG;

        $viewRenderData[$containerNs] = $this->getContainersRenderData(
            $view,
            $request
        );

        return $viewRenderData;
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
        $hasTag = (0 === strpos($layoutTag, PropertiesContainer::RENDER_TAG));

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
     * @param View                   $view
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    protected function getContainersRenderData(
        View $view,
        ServerRequestInterface $request
    ) {
        $siteCmsResource = $view->getSiteCmsResource();

        $layout = $view->getLayout();

        $layoutTags = $this->findTagNamesByLayout->__invoke(
            $layout
        );

        $containerPaths = $this->findContainerPaths(
            $layoutTags
        );

        $containerCmsResources = $this->findContainerCmsResourceBySitePaths->__invoke(
            $siteCmsResource->getId(),
            $containerPaths
        );

        $renderData = [];

        /** @var ContainerCmsResource $containerCmsResource */
        foreach ($containerCmsResources as $containerCmsResource) {

            /** @var Container $container */
            $container = $this->findContainerVersion->__invoke(
                $containerCmsResource->getContentVersionId()
            );

            $renderData[$containerCmsResource->getPath()] = $this->getContainerRenderData->__invoke(
                $container,
                $request
            );
        }

        return $renderData;
    }
}
