<?php

namespace Zrcms\HttpAssetsApplicationState\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\CoreApplicationState\Api\GetApplicationState;
use Zrcms\Debug\IsDebug;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderScriptTagApplicationStateFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderScriptTagApplicationState
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new RenderScriptTagApplicationState(
            $serviceContainer->get(GetApplicationState::class),
            $serviceContainer->get(RenderTag::class),
            IsDebug::invoke()
        );
    }
}
