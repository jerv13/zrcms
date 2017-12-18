<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CorePage\Exception\PageNotFound;
use Zrcms\CoreSite\Exception\SiteNotFound;
use Zrcms\CoreView\Api\GetViewByRequest;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithView
{
    const ATTRIBUTE_VIEW = 'zrcms-view';
    const ATTRIBUTE_MESSAGE = 'zrcms-view-message';

    /**
     * @var GetViewByRequest
     */
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
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $message = '';

        try {
            /** @var View $view */
            $view = $this->getViewByRequest->__invoke(
                $request
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
