<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Api\GetViewByRequest;
use Zrcms\CoreView\Exception\PageNotFound;
use Zrcms\CoreView\Exception\SiteNotFound;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithView
{
    const ATTRIBUTE_VIEW = 'zrcms-view';
    const ATTRIBUTE_MESSAGE = 'zrcms-view-message';

    protected $getViewByRequest;

    /**
     * @param GetViewByRequest $getViewByRequest
     */
    public function __construct(
        GetViewByRequest $getViewByRequest
    ) {
        $this->getViewByRequest = $getViewByRequest;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return mixed
     * @throws ViewDataNotFound
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $message = '';

        $getViewOptions = $request->getAttribute(
            RequestWithGetViewOptions::ATTRIBUTE_GET_VIEW_OPTIONS,
            []
        );

        try {
            /** @var View $view */
            $view = $this->getViewByRequest->__invoke(
                $request,
                $getViewOptions
            );
        } catch (SiteNotFound $exception) {
            $view = null;
            $message = $exception->getMessage();
        } catch (PageNotFound $exception) {
            $view = null;
            $message = $exception->getMessage();
        }

        $request = $request
            ->withAttribute(self::ATTRIBUTE_VIEW, $view)
            ->withAttribute(self::ATTRIBUTE_MESSAGE, $message);

        return $next($request, $response);
    }
}
