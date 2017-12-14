<?php

namespace Zrcms\CoreContainer\Api\Render;

use Zrcms\Core\Model\Content;
use Zrcms\CoreContainer\Model\Container;
use Zrcms\CoreContainer\Fields\FieldsContainer;
use Zrcms\CoreContainer\Model\ServiceAliasContainer;
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
    ): string {
        // Get version renderer or use default
        $renderContainerServiceAlias = $container->findProperty(
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
