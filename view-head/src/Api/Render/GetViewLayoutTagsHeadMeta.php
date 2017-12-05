<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Component\FindComponent;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\PageVersion;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponent;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;
use Zrcms\ViewHtmlTags\Api\Render\RenderTags;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsHeadMeta implements GetViewLayoutTagsHead
{
    const RENDER_TAG_META = 'head-meta';
    const SERVICE_ALIAS = 'head-meta';

    /**
     * @var FindComponent
     */
    protected $findComponent;

    /**
     * @var RenderTags
     */
    protected $renderTags;

    /**
     * @param FindComponent $findComponent
     * @param RenderTags                  $renderTags
     */
    public function __construct(
        FindComponent $findComponent,
        RenderTags $renderTags
    ) {
        $this->findComponent = $findComponent;
        $this->renderTags = $renderTags;
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
        /** @var ViewLayoutTagsComponent $getViewLayoutTagsHeadLinkComponent */
        $component = $this->findComponent->__invoke(
            'view-layout-tag',
            self::RENDER_TAG_META
        );

        $tagsData = $component->getProperty(
            'tags',
            []
        );

        // descriptions and keywords always from page then site
        /** @var PageVersion $pageVersion */
        $pageVersion = $view->getPageCmsResource()->getContentVersion();

        $tagsData[] = [
            //'tag' => 'meta',
            'attributes' => [
                'name' => 'description',
                'content' => $pageVersion->getDescription()
            ],
        ];

        $tagsData[] = [
            //'tag' => 'meta',
            'attributes' => [
                'name' => 'keywords',
                'content' => $pageVersion->getKeywords()
            ],
        ];

        foreach ($tagsData as $key => $tag) {
            $tagsData[$key]['tag'] = 'meta';
        }

        // @todo We can fall back to site description and site keywords if they exist?

        return [
            self::RENDER_TAG_META => $this->renderTags->__invoke($tagsData, [RenderTag::OPTION_INDENT => '    '])
        ];
    }
}
