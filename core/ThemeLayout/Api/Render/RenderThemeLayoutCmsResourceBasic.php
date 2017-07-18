<?php

namespace Zrcms\Core\ThemeLayout\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Content\Api\Render\RenderCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\ThemeLayout\Model\ThemeLayoutCmsResource;
use Zrcms\Core\ThemeLayout\Model\ThemeLayoutProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderThemeLayoutCmsResourceBasic implements RenderThemeLayoutCmsResource
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var string
     */
    protected $defaultRenderServiceName;

    /**
     * @param ContainerInterface $serviceContainer
     * @param string             $defaultRenderServiceName
     */
    public function __construct(
        $serviceContainer,
        string $defaultRenderServiceName = RenderThemeLayoutCmsResourceMustache::class
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->defaultRenderServiceName = $defaultRenderServiceName;
    }

    /**
     * @param ThemeLayoutCmsResource|CmsResource $layoutCmsResource
     * @param array                              $renderData ['templateTag' => '{html}']
     * @param array                              $options
     *
     * @return string
     */
    public function __invoke(
        CmsResource $layoutCmsResource,
        array $renderData,
        array $options = []
    ): string
    {
        $layout = $layoutCmsResource->getContent();

        $renderServiceName = $layout->getProperty(
            ThemeLayoutProperties::RENDER,
            $this->defaultRenderServiceName
        );

        /** @var RenderCmsResource $render */
        $render = $this->serviceContainer->get(
            $renderServiceName
        );

        return $render->__invoke(
            $layoutCmsResource,
            $renderData
        );
    }
}
