<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Model\Content;
use Zrcms\CorePage\Model\PageVersion;
use Zrcms\CoreSite\Fields\FieldsSite;
use Zrcms\CoreSite\Model\SiteVersion;
use Zrcms\CoreView\Model\View;
use Zrcms\CoreView\Model\ViewLayoutTagsComponent;
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
     * @param RenderTags    $renderTags
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
    ): array {
        /** @var ViewLayoutTagsComponent $getViewLayoutTagsHeadLinkComponent */
        $component = $this->findComponent->__invoke(
            'view-layout-tag',
            self::RENDER_TAG_META
        );

        $tagsData = $component->findProperty(
            'tags',
            []
        );

        // descriptions and keywords always from page then site
        /** @var PageVersion $pageVersion */
        $pageVersion = $view->getPageCmsResource()->getContentVersion();
        /** @var SiteVersion $siteVersion */
        $siteVersion = $view->getSiteCmsResource()->getContentVersion();

        $tagsData[] = [
            //'tag' => 'meta',
            'attributes' => [
                'name' => 'description',
                'content' => $this->buildDescription($pageVersion, $siteVersion),
            ],
        ];

        $tagsData[] = [
            //'tag' => 'meta',
            'attributes' => [
                'name' => 'keywords',
                'content' => $this->buildKeywords($pageVersion, $siteVersion),
            ],
        ];

        foreach ($tagsData as $key => $tag) {
            $tagsData[$key]['tag'] = 'meta';
        }

        return [
            self::RENDER_TAG_META => $this->renderTags->__invoke($tagsData, [RenderTag::OPTION_INDENT => '    '])
        ];
    }

    /**
     * @param PageVersion $pageVersion
     * @param SiteVersion $siteVersion
     *
     * @return string
     */
    protected function buildDescription(
        PageVersion $pageVersion,
        SiteVersion $siteVersion
    ):string {
        $description = $pageVersion->getDescription();

        if (empty($description)) {
            $description = $siteVersion->findProperty(
                FieldsSite::DESCRIPTION,
                ''
            );
        }

        return strip_tags($description);
    }

    /**
     * @param PageVersion $pageVersion
     * @param SiteVersion $siteVersion
     *
     * @return string
     */
    protected function buildKeywords(
        PageVersion $pageVersion,
        SiteVersion $siteVersion
    ):string {
        $keywords = $pageVersion->getKeywords();

        if (empty($keywords)) {
            $keywords = $siteVersion->findProperty(
                FieldsSite::KEYWORDS,
                ''
            );
        }

        return strip_tags($keywords);
    }
}
