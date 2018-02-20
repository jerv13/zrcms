<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CorePage\Api\Content\FindPageVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestByPageVersionFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetViewByRequestByPageVersion
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetViewByRequestByPageVersion(
            $serviceContainer->get(GetSiteCmsResource::class),
            $serviceContainer->get(GetThemeName::class),
            $serviceContainer->get(FindPageVersion::class),
            $serviceContainer->get(GetLayoutName::class),
            $serviceContainer->get(GetLayoutCmsResource::class),
            $serviceContainer->get(BuildView::class),
            GetViewByRequestByPageVersion::DEFAULT_PAGE_CMS_RESOURCE_TEMP_ID
        );
    }
}
