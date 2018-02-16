<?php

namespace Zrcms\HttpAssetsAdminTools\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\CoreAdminTools\Api\Acl\IsAllowedAdminToolsRcmUserSitesAdmin;
use Zrcms\Debug\IsDebug;
use Zrcms\HttpAssets\Api\GetCacheBreaker;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderLinkHrefTagAdminToolsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderLinkHrefTagAdminTools
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new RenderLinkHrefTagAdminTools(
            $serviceContainer->get(IsAllowedAdminToolsRcmUserSitesAdmin::class),
            [],
            $serviceContainer->get(RenderTag::class),
            $serviceContainer->get(GetCacheBreaker::class),
            IsDebug::invoke()
        );
    }
}
