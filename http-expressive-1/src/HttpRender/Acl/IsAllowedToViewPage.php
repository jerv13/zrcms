<?php

namespace Zrcms\HttpExpressive1\HttpRender;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\HttpExpressive1\HttpAlways\RequestWithView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedToViewPage
{
    /**
     * __invoke
     *
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
