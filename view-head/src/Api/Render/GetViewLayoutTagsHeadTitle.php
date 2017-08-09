<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Site\Model\PropertiesSite;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewLayoutTagsHeadTitle implements GetViewLayoutTagsHead
{
    const RENDER_TAG_TITLE = 'head-title';
    const SERVICE_ALIAS = 'head-title';

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
        $pageVersion = $view->getPage();

        $title = $pageVersion->getTitle();

        if (empty($title)) {
            $siteVersion = $view->getSite();
            $title = $siteVersion->getProperty(
                PropertiesSite::TITLE
            );
        }

        $title = strip_tags($title);

        return [
            self::RENDER_TAG_TITLE => "<title>$title</title>"
        ];
    }
}
