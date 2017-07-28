<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\View;

/**
 *
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderDataHeadAll implements GetViewRenderDataHead
{
    const RENDER_TAG_ALL = 'all';

    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

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
     * @param ContainerInterface $serviceContainer
     * @param array              $renderServiceNames ['{tag-property-name}' => '{GetViewRenderDataHeadServiceName}']
     */
    public function __construct(
        $serviceContainer,
        array $renderServiceNames = []
    ) {
        $this->serviceContainer = $serviceContainer;
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

        foreach ($this->renderServiceNames as $renderTag => $renderServiceName) {
            /** @var GetViewRenderDataHead $renderService */
            $renderService = $this->serviceContainer->get(
                $renderServiceName
            );

            if (get_class($renderService) == get_class($this)) {
                throw new \Exception(
                    'Class ' . get_class($this) . ' can not use itself as service.'
                );
            }

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
