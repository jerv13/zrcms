<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\CoreView\Model\View;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 *
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsHeadAll implements GetViewLayoutTagsHead
{
    const RENDER_TAG_ALL = 'head-all';
    const SERVICE_ALIAS = 'head-all';

    /**
     * @var GetServiceFromAlias
     */
    protected $getServiceFromAlias;

    /**
     * @var string
     */
    protected $serviceAliasNamespace;

    /**
     * @var array
     */
    protected $renderServiceAliases
        = [
            GetViewLayoutTagsHeadMeta::RENDER_TAG_META => GetViewLayoutTagsHeadMeta::SERVICE_ALIAS,
            GetViewLayoutTagsHeadTitle::RENDER_TAG_TITLE => GetViewLayoutTagsHeadTitle::SERVICE_ALIAS,
            GetViewLayoutTagsHeadLink::RENDER_TAG_LINK => GetViewLayoutTagsHeadLink::SERVICE_ALIAS,
            GetViewLayoutTagsHeadScript::RENDER_TAG_SCRIPT => GetViewLayoutTagsHeadScript::SERVICE_ALIAS,
        ];

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param array               $renderServiceAliases ['{tag-property-name}' => '{GetViewLayoutTagsHeadServiceAlias}']
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        array $renderServiceAliases = []
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasView::ZRCMS_COMPONENT_VIEW_LAYOUT_TAGS_GETTER;
        $this->renderServiceAliases = array_merge(
            $this->renderServiceAliases,
            $renderServiceAliases
        );
    }

    /**
     * @param View|Content           $view
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     * @throws \Exception
     */
    public function __invoke(
        Content $view,
        ServerRequestInterface $request,
        array $options = []
    ): array {
        $renderTags = [];

        foreach ($this->renderServiceAliases as $renderTag => $renderServiceAlias) {
            /** @var GetViewLayoutTagsHead $renderService */
            $renderService = $this->getServiceFromAlias->__invoke(
                $this->serviceAliasNamespace,
                $renderServiceAlias,
                GetViewLayoutTagsHead::class,
                ''
            );

            ServiceCheck::assertNotSelfReference($this, $renderService);

            $subRenderTags = $renderService->__invoke(
                $view,
                $request,
                $options
            );

            $renderTags = array_merge(
                $renderTags,
                $subRenderTags
            );
        }

        $mergedHtml = '';

        foreach ($renderTags as $html) {
            $mergedHtml .= "\n" . $html;
        }

        return [
            self::RENDER_TAG_ALL => $mergedHtml
        ];
    }
}
