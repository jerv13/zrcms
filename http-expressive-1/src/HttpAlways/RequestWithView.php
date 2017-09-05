<?php

namespace Zrcms\HttpExpressive1\HttpAlways;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\Page\Exception\PageNotFoundException;
use Zrcms\ContentCore\Site\Exception\SiteNotFoundException;
use Zrcms\ContentCore\View\Api\GetViewByRequest;
use Zrcms\ContentCore\View\Model\View;
use Zrcms\HttpExpressive1\Model\RequestedPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithView
{
    const ATTRIBUTE_VIEW = 'zrcms-view';
    const ATTRIBUTE_HTTP_STATUS = 'zrcms-view-http-status';
    const ATTRIBUTE_HTTP_MESSAGE = 'zrcms-view-http-message';
    const ATTRIBUTE_MESSAGE = 'zrcms-view-message';
    const ATTRIBUTE_REQUEST_PATH = RequestedPage::PROPERTY_PATH;

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
        $path = $request->getUri()->getPath();

        $additionalViewProperties = [
            self::ATTRIBUTE_REQUEST_PATH => $path,
        ];

        try {
            /** @var View $view */
            $view = $this->getViewByRequest->__invoke(
                $request,
                [
                    GetViewByRequest::OPTION_ADDITIONAL_PROPERTIES
                    => $additionalViewProperties
                ]
            );

            $status = 200;
            $httpMessage = 'OK';
            $message = '';
        } catch (SiteNotFoundException $exception) {
            $view = null;
            $status = 404;
            $httpMessage = 'SITE NOT FOUND';
            $message = $exception->getMessage();
        } catch (PageNotFoundException $exception) {
            $view = null;
            $status = 404;
            $httpMessage = 'PAGE NOT FOUND';
            $message = $exception->getMessage();
        }

        $request = $request
            ->withAttribute(self::ATTRIBUTE_VIEW, $view)
            ->withAttribute(self::ATTRIBUTE_HTTP_STATUS, $status)
            ->withAttribute(self::ATTRIBUTE_HTTP_MESSAGE, $httpMessage)
            ->withAttribute(self::ATTRIBUTE_MESSAGE, $message)
            ->withAttribute(self::ATTRIBUTE_REQUEST_PATH, $path);

        return $next($request, $response);
    }
}
