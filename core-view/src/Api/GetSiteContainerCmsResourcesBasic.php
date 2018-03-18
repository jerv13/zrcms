<?php

namespace Zrcms\CoreView\Api;

use Reliv\ArrayProperties\Property;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBySitePaths;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Model\ContainerCmsResource;
use Zrcms\CoreContainerDoctrine\Api\CmsResource\FindContainerCmsResourcesBy;
use Zrcms\CoreTheme\Model\LayoutVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSiteContainerCmsResourcesBasic implements GetSiteContainerCmsResources
{
    const RENDER_TAG_CONTAINER = 'container';

    protected $findContainerCmsResourcesBy;
    protected $getTagNamesByLayout;
    protected $findContainerCmsResourcesBySitePaths;
    protected $getContainerRenderTags;

    /**
     * @param FindContainerCmsResourcesBy          $findContainerCmsResourcesBy
     * @param GetTagNamesByLayout                  $getTagNamesByLayout
     * @param FindContainerCmsResourcesBySitePaths $findContainerCmsResourcesBySitePaths
     * @param GetContainerRenderTags               $getContainerRenderTags
     */
    public function __construct(
        FindContainerCmsResourcesBy $findContainerCmsResourcesBy,
        GetTagNamesByLayout $getTagNamesByLayout,
        FindContainerCmsResourcesBySitePaths $findContainerCmsResourcesBySitePaths,
        GetContainerRenderTags $getContainerRenderTags
    ) {
        $this->findContainerCmsResourcesBy =$findContainerCmsResourcesBy;
        $this->getTagNamesByLayout = $getTagNamesByLayout;
        $this->findContainerCmsResourcesBySitePaths = $findContainerCmsResourcesBySitePaths;
        $this->getContainerRenderTags = $getContainerRenderTags;
    }

    /**
     * @param string $siteCmsResourceId
     * @param array  $options
     *
     * @return ContainerCmsResource[]
     * @throws \Exception
     */
    public function __invoke(
        string $siteCmsResourceId,
        array $options = []
    ): array {
        $layoutVersion = Property::get(
            $options,
            self::OPTION_LAYOUT_VERSION
        );

        if($layoutVersion instanceof LayoutVersion) {
            return $this->getLayoutContainers(
                $siteCmsResourceId,
                $layoutVersion
            );
        }

        return $this->findContainerCmsResourcesBy->__invoke(
            ['siteCmsResourceId' => $siteCmsResourceId]
        );
    }

    /**
     * @param string   $siteCmsResourceId
     * @param LayoutVersion $layoutVersion
     *
     * @return ContainerCmsResource[]
     */
    protected function getLayoutContainers(
        string $siteCmsResourceId,
        LayoutVersion $layoutVersion
    ) {
        $layoutTags = $this->getTagNamesByLayout->__invoke(
            $layoutVersion
        );

        $containerPaths = $this->findContainerPaths(
            $layoutTags
        );

        return $this->findContainerCmsResourcesBySitePaths->__invoke(
            $siteCmsResourceId,
            $containerPaths
        );
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
                $paths[] = $path;
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
        $hasTag = (0 === strpos($layoutTag, self::RENDER_TAG_CONTAINER));

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
