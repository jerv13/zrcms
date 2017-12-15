<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Model\Content;
use Zrcms\CoreView\Model\View;
use Zrcms\ViewHead\Model\HeadSectionComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsHeadLink implements GetViewLayoutTagsHead
{
    const RENDER_TAG_LINK = 'head-link';
    const SERVICE_ALIAS = 'head-link';
    const TAG_TYPE = 'head-link';

    /**
     * @var FindComponent
     */
    protected $findComponent;

    /**
     * @var RenderHeadSectionsTag
     */
    protected $renderHeadSectionsTag;

    /**
     * @param FindComponent $findComponent
     * @param RenderHeadSectionsTag       $renderHeadSectionsTag
     */
    public function __construct(
        FindComponent $findComponent,
        RenderHeadSectionsTag $renderHeadSectionsTag
    ) {
        $this->findComponent = $findComponent;
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
    ): array {
        /** @var HeadSectionComponent $component */
        $component = $this->findComponent->__invoke(
            'view-layout-tag',
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
