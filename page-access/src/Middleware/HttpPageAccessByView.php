<?php

namespace Zrcms\PageAccess\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
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
class HttpPageAccessByView implements MiddlewareInterface
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
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|HtmlResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $view = $request->getAttribute(
            RequestWithView::ATTRIBUTE_VIEW
        );

        /** @var View $view */
        if (empty($view)) {
            return $delegate->process($request);
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
            return $delegate->process($request);
        }

        return new HtmlResponse(
            'UNAUTHORIZED',
            401,
            ['reason-phrase' => 'UNAUTHORIZED: PAGE ACCESS']
        );
    }
}
