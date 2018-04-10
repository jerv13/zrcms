<?php

namespace Zrcms\HttpViewRender\Request;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
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
class RequestWithView implements MiddlewareInterface
{
    const ATTRIBUTE_VIEW = 'zrcms-view';
    const ATTRIBUTE_MESSAGE = 'zrcms-view-message';

    protected $getViewByRequest;
    protected $getViewByRequestOptions;

    /**
     * @param GetViewByRequest $getViewByRequest
     * @param array            $getViewByRequestOptions
     */
    public function __construct(
        GetViewByRequest $getViewByRequest,
        array $getViewByRequestOptions = []
    ) {
        $this->getViewByRequest = $getViewByRequest;
        $this->getViewByRequestOptions = $getViewByRequestOptions;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return mixed|ResponseInterface
     * @throws ViewDataNotFound
     * @throws \Zrcms\CoreView\Exception\InvalidGetViewByRequest
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $message = '';

        try {
            /** @var View $view */
            $view = $this->getViewByRequest->__invoke(
                $request,
                $this->getViewByRequestOptions
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

        return $delegate->process($request);
    }
}
