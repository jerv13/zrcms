<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CoreView\Model\View;
use Zrcms\ViewHead\Api\GetSections;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsHeadScript implements GetViewLayoutTagsHead
{
    const RENDER_TAG_SCRIPT = 'head-script';
    const SERVICE_ALIAS = 'head-script';
    const TAG_TYPE = 'head-script';
    const HTML_TAG = 'script';

    protected $getSections;
    protected $renderHeadSectionsTag;

    /**
     * @param GetSections           $getSections
     * @param RenderHeadSectionsTag $renderHeadSectionsTag
     */
    public function __construct(
        GetSections $getSections,
        RenderHeadSectionsTag $renderHeadSectionsTag
    ) {
        $this->getSections = $getSections;
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
        $sections = $this->getSections->__invoke(
            self::RENDER_TAG_SCRIPT,
            $request
        );

        $html = $this->renderHeadSectionsTag->__invoke(
            $view,
            $request,
            self::HTML_TAG,
            $sections,
            $options
        );

        return [
            self::RENDER_TAG_SCRIPT => $html
        ];
    }
}
