<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponent;
use Zrcms\ViewHead\Model\HeadSection;
use Zrcms\ViewHead\Model\HeadSectionBasic;
use Zrcms\ViewHead\Model\PropertiesHeadSection;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsHeadScript implements GetViewLayoutTagsHead
{
    const RENDER_TAG_SCRIPT = 'head-script';
    const SERVICE_ALIAS = 'head-script';

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
            self::RENDER_TAG_SCRIPT => $html
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
        /** @var ViewLayoutTagsComponent $getViewLayoutTagsHeadLinkComponent */
        $component = $this->findViewLayoutTagsComponent->__invoke(
            self::RENDER_TAG_SCRIPT
        );

        $properties = $component->getProperties();
        $properties[PropertiesHeadSection::ID] = 'head-script:' . time();

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
