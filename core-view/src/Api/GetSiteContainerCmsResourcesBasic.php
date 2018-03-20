<?php

namespace Zrcms\CoreView\Api;

use Reliv\ArrayProperties\Property;
use Zrcms\CoreContainer\Api\CmsResource\FindContainerCmsResourcesBySiteNames;
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
    protected $findContainerCmsResourcesBySiteNames;
    protected $getContainerRenderTags;

    /**
     * @param FindContainerCmsResourcesBy          $findContainerCmsResourcesBy
     * @param GetTagNamesByLayout                  $getTagNamesByLayout
     * @param FindContainerCmsResourcesBySiteNames $findContainerCmsResourcesBySiteNames
     * @param GetContainerRenderTags               $getContainerRenderTags
     */
    public function __construct(
        FindContainerCmsResourcesBy $findContainerCmsResourcesBy,
        GetTagNamesByLayout $getTagNamesByLayout,
        FindContainerCmsResourcesBySiteNames $findContainerCmsResourcesBySiteNames,
        GetContainerRenderTags $getContainerRenderTags
    ) {
        $this->findContainerCmsResourcesBy =$findContainerCmsResourcesBy;
        $this->getTagNamesByLayout = $getTagNamesByLayout;
        $this->findContainerCmsResourcesBySiteNames = $findContainerCmsResourcesBySiteNames;
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

        $containerNames = $this->findContainerNames(
            $layoutTags
        );

        return $this->findContainerCmsResourcesBySiteNames->__invoke(
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
