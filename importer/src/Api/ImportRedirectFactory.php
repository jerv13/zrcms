<?php

namespace Zrcms\Importer\Api;

use Psr\Container\ContainerInterface;
use Zrcms\CoreRedirect\Api\CmsResource\CreateRedirectCmsResource;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResource;
use Zrcms\CoreRedirect\Api\Content\InsertRedirectVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImportRedirectFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImportRedirect
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ImportRedirect(
            $serviceContainer->get(ImportUtilities::class),
            $serviceContainer->get(FindRedirectCmsResource::class),
            $serviceContainer->get(InsertRedirectVersion::class),
            $serviceContainer->get(CreateRedirectCmsResource::class)
        );
    }
}
