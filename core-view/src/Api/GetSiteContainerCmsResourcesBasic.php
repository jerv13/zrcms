<?php

namespace Zrcms\CoreView\Api;

use Reliv\ArrayProperties\Property;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Model\ContainerCmsResource;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesBy;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesBySiteNames;
use Zrcms\CoreTheme\Model\LayoutVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSiteContainerCmsResourcesBasic implements GetSiteContainerCmsResources
{
    const RENDER_TAG_CONTAINER = 'container';

    protected $findSiteContainerCmsResourcesBy;
    protected $getTagNamesByLayout;
    protected $findSiteContainerCmsResourcesBySiteNames;
    protected $getContainerRenderTags;

    /**
     * @param FindSiteContainerCmsResourcesBy          $findSiteContainerCmsResourcesBy
     * @param GetTagNamesByLayout                      $getTagNamesByLayout
     * @param FindSiteContainerCmsResourcesBySiteNames $findSiteContainerCmsResourcesBySiteNames
     * @param GetContainerRenderTags                   $getContainerRenderTags
     */
    public function __construct(
        FindSiteContainerCmsResourcesBy $findSiteContainerCmsResourcesBy,
        GetTagNamesByLayout $getTagNamesByLayout,
        FindSiteContainerCmsResourcesBySiteNames $findSiteContainerCmsResourcesBySiteNames,
        GetContainerRenderTags $getContainerRenderTags
    ) {
        $this->findSiteContainerCmsResourcesBy = $findSiteContainerCmsResourcesBy;
        $this->getTagNamesByLayout = $getTagNamesByLayout;
        $this->findSiteContainerCmsResourcesBySiteNames = $findSiteContainerCmsResourcesBySiteNames;
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

        if ($layoutVersion instanceof LayoutVersion) {
            return $this->getLayoutContainers(
                $siteCmsResourceId,
                $layoutVersion
            );
        }

        return $this->findSiteContainerCmsResourcesBy->__invoke(
            ['siteCmsResourceId' => $siteCmsResourceId]
        );
    }

    /**
     * @param string        $siteCmsResourceId
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

        $containerNames = $this->findContainerNames(
            $layoutTags
        );

        return $this->findSiteContainerCmsResourcesBySiteNames->__invoke(
            $siteCmsResourceId,
            $containerNames
        );
    }

    /**
     * @param array $layoutTags
     *
     * @return array
     */
    protected function findContainerNames(
        array $layoutTags
    ) {
        $names = [];
        foreach ($layoutTags as $layoutTag) {
            $name = $this->getName($layoutTag);
            if ($name !== null) {
                $names[] = $name;
            }
        }

        return $names;
    }

    /**
     * @todo NOTE: this will only work with tags like container.{name}
     * @todo Not with container.something.{name}
     *
     * @param string $layoutTag
     *
     * @return bool
     */
    protected function getName(string $layoutTag)
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
