<?php

namespace Zrcms\PageAccess\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\CoreView\Model\View;
use Zrcms\HttpViewRender\Request\RequestWithView;
use Zrcms\PageAccess\Api\Acl\IsAllowedPageAccess;
use Zrcms\PageAccess\Fields\FieldsPageAccess;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PageAccessByView
{
    protected $isAllowedPageAccess;

    /**
     * @param IsAllowedPageAccess $isAllowedPageAccess
     */
    public function __construct(
        IsAllowedPageAccess $isAllowedPageAccess
    ) {
        $this->isAllowedPageAccess = $isAllowedPageAccess;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $view = $request->getAttribute(
            RequestWithView::ATTRIBUTE_VIEW
        );

        /** @var View $view */
        if (empty($view)) {
            return $next($request, $response);
        }

        $pageCmsResource = $view->getPageCmsResource();

        $pageAccessOptions = $pageCmsResource->getContentVersion()->findProperty(
            FieldsPageAccess::PAGE_ACCESS_OPTIONS,
            []
        );

        $allowed = $this->isAllowedPageAccess->__invoke(
            $request,
            $pageAccessOptions
        );

        if ($allowed) {
            return $next($request, $response);
        }

        return new HtmlResponse(
            'UNAUTHORIZED',
            401,
            ['reason-phrase' => 'UNAUTHORIZED: PAGE ACCESS']
        );
    }
}
