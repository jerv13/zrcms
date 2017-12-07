<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Model\Content;
use Zrcms\CoreSite\Fields\FieldsSite;
use Zrcms\CoreView\Model\View;

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
        $pageVersion = $view->getPageCmsResource()->getContentVersion();

        $title = $pageVersion->getTitle();

        if (empty($title)) {
            $siteVersion = $view->getSiteCmsResource()->getContentVersion();
            $title = $siteVersion->getProperty(
                FieldsSite::TITLE
            );
        }

        $title = strip_tags($title);

        return [
            self::RENDER_TAG_TITLE => "<title>$title</title>"
        ];
    }
}
