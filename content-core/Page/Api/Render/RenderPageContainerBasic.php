<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\Page;
use Zrcms\ContentCore\Page\Model\PropertiesPage;
use Zrcms\ContentCore\Page\Model\ServiceAliasPageContainer;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderPageContainerBasic implements RenderPageContainer
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
    protected $defaultRenderPageContainerServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultRenderPageContainerServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultRenderPageContainerServiceName = RenderPageContainerRows::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasPageContainer::NAMESPACE_CONTENT_RENDERER;
        $this->defaultRenderPageContainerServiceName = $defaultRenderPageContainerServiceName;
    }

    /**
     * @param Page|Content $pageContainer
     * @param array        $renderData ['render-tag' => '{html}']
     * @param array        $options
     *
     * @return string
     */
    public function __invoke(
        Content $pageContainer,
        array $renderData,
        array $options = []
    ): string
    {
        // Get version renderer or use default
        $renderPageContainerServiceAlias = $pageContainer->getProperty(
            PropertiesPage::RENDERER,
            ''
        );

        /** @var RenderPageContainer $renderPageContainerService */
        $renderPageContainerService = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $renderPageContainerServiceAlias,
            RenderPageContainer::class,
            $this->defaultRenderPageContainerServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $renderPageContainerService);

        return $renderPageContainerService->__invoke(
            $pageContainer,
            $renderData
        );
    }
}
