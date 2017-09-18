<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\Page;
use Zrcms\ContentCore\Page\Fields\FieldsPage;
use Zrcms\ContentCore\Page\Model\ServiceAliasPageContainer;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageContainerRenderTagsBasic implements GetPageContainerRenderTags
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
    protected $defaultGetPageContainerRenderTagsServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultGetPageContainerRenderTagsServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultGetPageContainerRenderTagsServiceName = GetPageContainerRenderTagsBlocks::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasPageContainer::NAMESPACE_CONTENT_RENDER_TAGS_GETTER;
        $this->defaultGetPageContainerRenderTagsServiceName
            = $defaultGetPageContainerRenderTagsServiceName;
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
        $getPageContainerRenderTagsServiceAlias = $pageContainer->getProperty(
            FieldsPage::RENDER_TAGS_GETTER,
            ''
        );

        /** @var GetPageContainerRenderTags $getPageContainerRenderTagsService */
        $getPageContainerRenderTagsService = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $getPageContainerRenderTagsServiceAlias,
            GetPageContainerRenderTags::class,
            $this->defaultGetPageContainerRenderTagsServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $getPageContainerRenderTagsService);

        return $getPageContainerRenderTagsService->__invoke(
            $pageContainer,
            $request,
            $options
        );
    }
}
