<?php

namespace Zrcms\ContentCore\Page\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\Page;
use Zrcms\ContentCore\Page\Model\PropertiesPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageContainerRenderTagsHtml implements GetPageContainerRenderTags
{
    /**
     * @param Page|Content           $pageContainer
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return string[] ['{render-tag' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $pageContainer,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        $renderedData = [];

        $renderedData[] = $pageContainer->getProperty(
            PropertiesPage::PRE_RENDERED_HTML
        );

        return $renderedData;
    }
}
