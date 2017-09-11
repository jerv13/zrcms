<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\PageContainerVersion;
use Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponent;
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
     * @var FindViewLayoutTagsComponent
     */
    protected $findViewLayoutTagsComponent;

    /**
     * @var RenderTags
     */
    protected $renderTags;

    /**
     * @param FindViewLayoutTagsComponent $findViewLayoutTagsComponent
     * @param RenderTags                  $renderTags
     */
    public function __construct(
        FindViewLayoutTagsComponent $findViewLayoutTagsComponent,
        RenderTags $renderTags
    ) {
        $this->findViewLayoutTagsComponent = $findViewLayoutTagsComponent;
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
        $component = $this->findViewLayoutTagsComponent->__invoke(
            self::RENDER_TAG_META
        );

        $tagsData = $component->getProperty(
            'tags',
            []
        );

        // descriptions and keywords always from page then site
        /** @var PageContainerVersion $pageVersion */
        $pageVersion = $view->getPageContainerCmsResource()->getContentVersion();

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
