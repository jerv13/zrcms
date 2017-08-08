<?php

namespace Zrcms\ViewLayoutTagsHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\ViewLayoutTags\Api\Repository\FindViewLayoutTagsComponent;
use Zrcms\ViewLayoutTagsHead\Model\HeadSection;
use Zrcms\ViewLayoutTagsHead\Model\HeadSectionBasic;
use Zrcms\ViewLayoutTagsHead\Model\PropertiesHeadSection;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewRenderTagsHeadLink implements GetViewRenderTagsHead
{
    const RENDER_TAG_LINK = 'head-link';
    const SERVICE_ALIAS = 'head-link';

    /**
     * @var FindViewLayoutTagsComponent
     */
    protected $findViewLayoutTagsComponent;

    /**
     * @var RenderHeadSectionsTag
     */
    protected $renderHeadSectionsTag;

    /**
     * @param FindViewLayoutTagsComponent $findViewLayoutTagsComponent
     * @param RenderHeadSectionsTag       $renderHeadSectionsTag
     */
    public function __construct(
        FindViewLayoutTagsComponent $findViewLayoutTagsComponent,
        RenderHeadSectionsTag $renderHeadSectionsTag
    ) {
        $this->findViewLayoutTagsComponent = $findViewLayoutTagsComponent;
        $this->renderHeadSectionsTag = $renderHeadSectionsTag;
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
        $headSection = $this->findHeadSection();

        $renderTags = $this->getHeadSectionRenderTags(
            $headSection,
            $request
        );

        $html = $this->renderHeadSectionsTag->__invoke(
            $headSection,
            $renderTags
        );

        return [
            self::RENDER_TAG_LINK => $html
        ];
    }

    /**
     * This is just here to mimic the other service
     *
     * @param string|null $id
     * @param array       $options
     *
     * @return HeadSection
     */
    protected function findHeadSection(
        string $id = null,
        array $options = []
    ) {
        $getViewRenderTagsHeadLinkComponent = $this->findViewLayoutTagsComponent->__invoke(
            GetViewRenderTagsHeadLink::RENDER_TAG_LINK
        );

        $properties = $getViewRenderTagsHeadLinkComponent->getProperties();
        $properties[PropertiesHeadSection::ID] = 'head-link:' . time();

        // take the properties directly from the component
        return new HeadSectionBasic(
            $properties
        );
    }

    /**
     * This is just here to mimic the other service
     *
     * @param Content                $headSection
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return array
     */
    protected function getHeadSectionRenderTags(
        Content $headSection,
        ServerRequestInterface $request,
        array $options = []
    ) {
        return $headSection->getProperties();
    }
}
