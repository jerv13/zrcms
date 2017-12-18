<?php

namespace Zrcms\HttpViewRender\Acl;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\HttpViewRender\Request\RequestWithView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedToViewPage
{
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

        if (empty($view)) {
            return $next($request, $response);
        }

        //@todo Check page permissions

        return $next($request, $response);
    }
}
