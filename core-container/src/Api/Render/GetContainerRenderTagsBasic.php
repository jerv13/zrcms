<?php

namespace Zrcms\CoreContainer\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CoreContainer\Model\Container;
use Zrcms\CoreContainer\Fields\FieldsContainer;
use Zrcms\CoreContainer\Model\ServiceAliasContainer;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetContainerRenderTagsBasic implements GetContainerRenderTags
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
    protected $defaultGetContainerRenderTagsServiceName;

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param string              $defaultGetContainerRenderTagsServiceName
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        string $defaultGetContainerRenderTagsServiceName = GetContainerRenderTagsBlocks::class
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasContainer::ZRCMS_CONTENT_RENDERER;
        $this->defaultGetContainerRenderTagsServiceName = $defaultGetContainerRenderTagsServiceName;
    }

    /**
     * @param Container|Content      $container
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $container,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $getContainerRenderTagsServiceAlias = $container->getProperty(
            FieldsContainer::RENDER_TAGS_GETTER,
            ''
        );

        /** @var GetContainerRenderTags $getContainerRenderTagsService */
        $getContainerRenderTagsService = $this->getServiceFromAlias->__invoke(
            $this->serviceAliasNamespace,
            $getContainerRenderTagsServiceAlias,
            GetContainerRenderTags::class,
            $this->defaultGetContainerRenderTagsServiceName
        );

        ServiceCheck::assertNotSelfReference($this, $getContainerRenderTagsService);

        return $getContainerRenderTagsService->__invoke(
            $container,
            $request,
            $options
        );
    }
}
