<?php

namespace Zrcms\ViewLayoutTagsHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ViewLayoutTagsHead\Model\HeadSection;

/**
 * @deprecated NOT USE YET
 * @author James Jervis - https://github.com/jerv13
 */
class GetHeadSectionRenderTagsBasic implements GetHeadSectionRenderTags
{
    /**
     * @param HeadSection|Content $headSection
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag}' => '{html}']
     */
    public function __invoke(
        Content $headSection,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        return [
            'tag' => $headSection->getTag(),
            'sections' => $headSection->getSections()
        ];
    }
}
