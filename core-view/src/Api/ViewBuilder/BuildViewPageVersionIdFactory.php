<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;
use Zrcms\CorePage\Api\Content\FindPageVersion;
use Zrcms\CoreView\Api\GetLayoutCmsResource;
use Zrcms\CoreView\Api\GetLayoutName;
use Zrcms\CoreView\Api\GetSiteCmsResource;
use Zrcms\CoreView\Api\GetThemeName;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewPageVersionIdFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return BuildViewPageVersionId
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new BuildViewPageVersionId(
            $serviceContainer->get(GetSiteCmsResource::class),
            $serviceContainer->get(GetThemeName::class),
            $serviceContainer->get(FindPageVersion::class),
            $serviceContainer->get(GetLayoutName::class),
            $serviceContainer->get(GetLayoutCmsResource::class),
            BuildViewPageVersionId::DEFAULT_PAGE_CMS_RESOURCE_TEMP_ID
        );
    }
}
