<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\Page;
use Zrcms\ContentCore\Page\Model\PropertiesPage;
use Zrcms\ContentCore\Page\Model\ServiceAliasPageContainer;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageContainerRenderDataBasic implements GetPageContainerRenderData
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
    protected $defaultGetPageContainerRenderDataServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultGetPageContainerRenderDataServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultGetPageContainerRenderDataServiceName = GetPageContainerRenderDataBlocks::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasPageContainer::NAMESPACE_CONTENT_RENDER_DATA_GETTER;
        $this->defaultGetPageContainerRenderDataServiceName
            = $defaultGetPageContainerRenderDataServiceName;
    }

    /**
     * @param Page|Content           $pageContainer
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $pageContainer,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        // Get version renderer or use default
        $getPageContainerRenderDataServiceAlias = $pageContainer->getProperty(
            PropertiesPage::RENDER_DATA_GETTER,
            ''
        );

        /** @var GetPageContainerRenderData $getPageContainerRenderDataService */
        $getPageContainerRenderDataService = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $getPageContainerRenderDataServiceAlias,
            GetPageContainerRenderData::class,
            $this->defaultGetPageContainerRenderDataServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $getPageContainerRenderDataService);

        return $getPageContainerRenderDataService->__invoke(
            $pageContainer,
            $request,
            $options
        );
    }
}
