<?php

namespace Zrcms\Core\Page\Api\Render;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\Content;
use Zrcms\Core\Page\Model\PagePreRendered;
use Zrcms\Core\Page\Model\PageProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetPageApplicationRenderData implements GetPageRenderData
{
    /**
     * @param PagePreRendered|Content $pagePreRendered
     * @param ServerRequestInterface  $request
     * @param array                   $options
     *
     * @return array ['templateTag' => '{html}']
     * @throws \Exception
     */
    public function __invoke(
        Content $pagePreRendered,
        ServerRequestInterface $request,
        array $options = []
    ): array
    {
        if (!$pagePreRendered instanceof PagePreRendered) {
            throw new \Exception('Invalid type, expected ' . PagePreRendered::class);
        }

        return [
            PageProperties::RENDER_NAMESPACE => $pagePreRendered->getHtml()
        ];
    }
}
