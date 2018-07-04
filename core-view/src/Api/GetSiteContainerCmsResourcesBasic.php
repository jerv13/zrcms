<?php

namespace Zrcms\CoreView\Api;

use Reliv\ArrayProperties\Property;
use Zrcms\CoreContainer\Model\ContainerCmsResource;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesBy;
use Zrcms\CoreSiteContainer\Api\CmsResource\FindSiteContainerCmsResourcesBySiteNames;
use Zrcms\CoreTheme\Model\LayoutVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetSiteContainerCmsResourcesBasic implements GetSiteContainerCmsResources
{
    protected $findSiteContainerCmsResourcesBy;
    protected $getContainerNamesByLayout;
    protected $findSiteContainerCmsResourcesBySiteNames;
    protected $parseReduceLayoutTagsSiteContainers;

    /**
     * @param FindSiteContainerCmsResourcesBy          $findSiteContainerCmsResourcesBy
     * @param GetContainerNamesByLayout                $getContainerNamesByLayout
     * @param FindSiteContainerCmsResourcesBySiteNames $findSiteContainerCmsResourcesBySiteNames
     */
    public function __construct(
        FindSiteContainerCmsResourcesBy $findSiteContainerCmsResourcesBy,
        GetContainerNamesByLayout $getContainerNamesByLayout,
        FindSiteContainerCmsResourcesBySiteNames $findSiteContainerCmsResourcesBySiteNames
    ) {
        $this->findSiteContainerCmsResourcesBy = $findSiteContainerCmsResourcesBy;
        $this->getContainerNamesByLayout = $getContainerNamesByLayout;
        $this->findSiteContainerCmsResourcesBySiteNames = $findSiteContainerCmsResourcesBySiteNames;
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
        $containerNames = $this->getContainerNamesByLayout->__invoke(
            $layoutVersion
        );

        return $this->findSiteContainerCmsResourcesBySiteNames->__invoke(
            $siteCmsResourceId,
            $containerNames
        );
    }
}
