<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Container\Api\Render\GetContainerRenderData;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerCmsResourcesBySitePaths;
use Zrcms\ContentCore\Container\Api\Repository\FindContainerVersion;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;
use Zrcms\ContentCore\Container\Model\PropertiesContainer;
use Zrcms\ContentCore\View\Api\Repository\FindTagNamesByLayout;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataContainers implements GetViewRenderData
{
    /**
     * @var FindTagNamesByLayout
     */
    protected $findTagNamesByLayout;

    /**
     * @var FindContainerCmsResourcesBySitePaths
     */
    protected $findContainerCmsResourcesBySitePaths;

    /**
     * @var FindContainerVersion
     */
    protected $findContainerVersion;

    /**
     * @var GetContainerRenderData
     */
    protected $getContainerRenderData;

    /**
     * @param FindTagNamesByLayout                 $findTagNamesByLayout
     * @param FindContainerCmsResourcesBySitePaths $findContainerCmsResourcesBySitePaths
     * @param FindContainerVersion                 $findContainerVersion
     * @param GetContainerRenderData               $getContainerRenderData
     */
    public function __construct(
        FindTagNamesByLayout $findTagNamesByLayout,
        FindContainerCmsResourcesBySitePaths $findContainerCmsResourcesBySitePaths,
        FindContainerVersion $findContainerVersion,
        GetContainerRenderData $getContainerRenderData
    ) {
        $this->findTagNamesByLayout = $findTagNamesByLayout;
        $this->findContainerCmsResourcesBySitePaths = $findContainerCmsResourcesBySitePaths;
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
        $siteCmsResource = $view->getSiteCmsResource();

        $layout = $view->getLayout();

        $layoutTags = $this->findTagNamesByLayout->__invoke(
            $layout
        );

        $containerPaths = $this->findContainerPaths(
            $layoutTags
        );

        $containerCmsResources = $this->findContainerCmsResourcesBySitePaths->__invoke(
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

        return [
            PropertiesContainer::RENDER_TAG => $renderData
        ];
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
}
