<?php

namespace Zrcms\ContentCore\Container\Api\Render;

use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Container\Model\Container;
use Zrcms\ContentCore\Container\Fields\FieldsContainer;
use Zrcms\ContentCore\Container\Model\ServiceAliasContainer;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

class RenderContainerBasic implements RenderContainer
{
    /**
     * @var GetServiceFromAlias
     */
    protected $getServiceFromAlias;

    /**
     * @var string
     */
    protected $serviceAliasNamespace;

    /**
     * @var string
     */
    protected $defaultRenderContainerServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultRenderContainerServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultRenderContainerServiceName = RenderContainerRows::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasContainer::ZRCMS_CONTENT_RENDERER;
        $this->defaultRenderContainerServiceName = $defaultRenderContainerServiceName;
    }

    /**
     * @param Container|Content $container
     * @param array             $renderTags ['render-tag' => '{html}']
     * @param array             $options
     *
     * @return string
     */
    public function __invoke(
        Content $container,
        array $renderTags,
        array $options = []
    ): string
    {
        // Get version renderer or use default
        $renderContainerServiceAlias = $container->getProperty(
            FieldsContainer::RENDERER,
            ''
        );

        /** @var RenderContainer $renderContainerService */
        $renderContainerService = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $renderContainerServiceAlias,
            RenderContainer::class,
            $this->defaultRenderContainerServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $renderContainerService);

        return $renderContainerService->__invoke(
            $container,
            $renderTags
        );
    }
}
