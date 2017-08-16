<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Api\Repository\FindViewLayoutTagsComponent;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\ViewHead\Model\HeadSectionComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsHeadLink implements GetViewLayoutTagsHead
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
        /** @var HeadSectionComponent $component */
        $component = $this->findViewLayoutTagsComponent->__invoke(
            self::RENDER_TAG_LINK
        );

        $tag = $component->getTag();
        $sections = $component->getSections();

        $html = $this->renderHeadSectionsTag->__invoke(
            $view,
            $request,
            $tag,
            $sections,
            $options
        );

        return [
            self::RENDER_TAG_LINK => $html
        ];
    }
}
