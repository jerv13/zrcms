<?php

namespace Zrcms\HttpExpressive\HttpAlways;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\Page\Exception\PageNotFoundException;
use Zrcms\ContentCore\Site\Exception\SiteNotFoundException;
use Zrcms\ContentCore\View\Api\GetViewByRequest;
use Zrcms\ContentCore\View\Model\View;

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
        $message = '';

        try {
            /** @var View $view */
            $view = $this->getViewByRequest->__invoke(
                $request
            );
        } catch (SiteNotFoundException $exception) {
            $view = null;
            $message = $exception->getMessage();
        } catch (PageNotFoundException $exception) {
            $view = null;
            $message = $exception->getMessage();
        }

        $request = $request
            ->withAttribute(self::ATTRIBUTE_VIEW, $view)
            ->withAttribute(self::ATTRIBUTE_MESSAGE, $message);

        return $next($request, $response);
    }
}
