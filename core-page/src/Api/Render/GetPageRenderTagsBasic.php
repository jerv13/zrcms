<?php

namespace Zrcms\CorePage\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CorePage\Model\Page;
use Zrcms\CorePage\Fields\FieldsPage;
use Zrcms\CorePage\Model\ServiceAliasPage;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageRenderTagsBasic implements GetPageRenderTags
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
    protected $defaultGetPageRenderTagsServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultGetPageRenderTagsServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultGetPageRenderTagsServiceName = GetPageRenderTagsContainers::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasPage::ZRCMS_CONTENT_RENDER_TAGS_GETTER;
        $this->defaultGetPageRenderTagsServiceName
            = $defaultGetPageRenderTagsServiceName;
    }

    /**
     * @param Page|Content           $page
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $page,
        ServerRequestInterface $request,
        array $options = []
    ): array {
        // Get version renderer or use default
        $getPageRenderTagsServiceAlias = $page->findProperty(
            FieldsPage::RENDER_TAGS_GETTER,
            ''
        );

        /** @var GetPageRenderTags $getPageRenderTagsService */
        $getPageRenderTagsService = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $getPageRenderTagsServiceAlias,
            GetPageRenderTags::class,
            $this->defaultGetPageRenderTagsServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $getPageRenderTagsService);

        return $getPageRenderTagsService->__invoke(
            $page,
            $request,
            $options
        );
    }
}
