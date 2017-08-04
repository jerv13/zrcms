<?php

namespace Zrcms\ViewRenderDataGetters\Head\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;
use Zrcms\ServiceAlias\ServiceCheck;

/**
 *
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataHeadAll implements GetViewRenderDataHead
{
    const RENDER_TAG_ALL = 'all';

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
    protected $renderServiceNames
        = [
            GetViewRenderDataHeadMeta::RENDER_TAG_META => GetViewRenderDataHeadMeta::class,
            GetViewRenderDataHeadTitle::RENDER_TAG_TITLE => GetViewRenderDataHeadTitle::class,
            GetViewRenderDataHeadLink::RENDER_TAG_LINK => GetViewRenderDataHeadLink::class,
            GetViewRenderDataHeadScript::RENDER_TAG_SCRIPT => GetViewRenderDataHeadScript::class,
        ];

    /**
     * @param GetServiceFromAlias $getServiceFromAlias
     * @param array               $renderServiceNames ['{tag-property-name}' => '{GetViewRenderDataHeadServiceAlias}']
     */
    public function __construct(
        GetServiceFromAlias $getServiceFromAlias,
        array $renderServiceNames = []
    ) {
        $this->getServiceFromAlias = $getServiceFromAlias;
        $this->serviceAliasNamespace = ServiceAliasView::NAMESPACE_CONTENT_RENDER_DATA_GETTER;
        $this->renderServiceNames = array_merge(
            $this->renderServiceNames,
            $renderServiceNames
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
    ): array
    {
        $renderData = [];

        foreach ($this->renderServiceNames as $renderTag => $renderServiceAlias) {
            /** @var GetViewRenderDataHead $renderService */
            $renderService = $this->getServiceFromAlias->__invoke(
                $this->serviceAliasNamespace,
                $renderServiceAlias,
                GetViewRenderDataHead::class,
                ''
            );

            ServiceCheck::assertNotSelfReference($this, $renderService);

            $subRenderData = $renderService->__invoke(
                $view,
                $request,
                $options
            );

            if (!is_array($subRenderData[GetViewRenderDataHead::RENDER_TAG])) {
                throw new \Exception(
                    get_class($this) . ' requires injected services to return array with '
                    . GetViewRenderDataHead::RENDER_TAG . ' as a key'
                );
            }

            $renderData = array_merge(
                $renderData,
                $subRenderData[GetViewRenderDataHead::RENDER_TAG]
            );
        }

        $mergedHtml = '';

        foreach ($renderData as $html) {
            $mergedHtml .= "\n" . $html;
        }

        return [
            GetViewRenderDataHead::RENDER_TAG => [
                self::RENDER_TAG_ALL => $mergedHtml
            ],
        ];
    }
}
