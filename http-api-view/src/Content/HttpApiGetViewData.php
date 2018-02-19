<?php

namespace Zrcms\HttpApiView\Content;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Uri;
use Zrcms\CoreView\Api\GetViewByRequest;
use Zrcms\CoreView\Api\ViewToArray;
use Zrcms\CoreView\Exception\LayoutNotFound;
use Zrcms\CoreView\Exception\PageNotFound;
use Zrcms\CoreView\Exception\SiteNotFound;
use Zrcms\CoreView\Exception\ThemeNotFound;
use Zrcms\CoreView\Model\View;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpViewRender\Request\RequestWithGetViewOptions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiGetViewData
{
    const ATTRIBUTE_HOST = 'host';
    const ATTRIBUTE_PATH = 'path';

    const SOURCE_MISSING_HOST = 'missing-host';
    const SOURCE_SITE = 'site';
    const SOURCE_PAGE = 'page';
    const SOURCE_THEME = 'theme';
    const SOURCE_LAYOUT = 'layout';
    const NAME = 'view-get-view-data';

    protected $getViewByRequest;
    protected $viewToArray;
    protected $notFoundStatus;
    protected $badRequestStatus;
    protected $debug;

    /**
     * @param GetViewByRequest $getViewByRequest
     * @param ViewToArray      $viewToArray
     * @param int              $notFoundStatus
     * @param int              $badRequestStatus
     * @param bool             $debug
     */
    public function __construct(
        GetViewByRequest $getViewByRequest,
        ViewToArray $viewToArray,
        int $notFoundStatus = 404,
        int $badRequestStatus = 400,
        bool $debug
    ) {
        $this->getViewByRequest = $getViewByRequest;
        $this->viewToArray = $viewToArray;
        $this->notFoundStatus = $notFoundStatus;
        $this->badRequestStatus = $badRequestStatus;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ZrcmsJsonResponse|JsonResponse
     * @throws \Exception
     * @throws \Zrcms\CoreView\Exception\ViewDataNotFound
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $host = $request->getAttribute(static::ATTRIBUTE_HOST);
        $path = $request->getAttribute(static::ATTRIBUTE_PATH, '');

        $path = '/' . $path;

        if (empty($host)) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)$this->badRequestStatus,
                    'BAD REQUEST',
                    static::NAME,
                    static::SOURCE_MISSING_HOST
                ),
                $this->notFoundStatus,
                [],
                BuildResponseOptions::invoke()
            );
        }

        $getViewOptions = $request->getAttribute(
            RequestWithGetViewOptions::ATTRIBUTE_GET_VIEW_OPTIONS,
            []
        );

        $uri = new Uri(
            'https://' . $host . $path
        );

        $fakeRequest = $request->withUri(
            $uri
        );

        try {
            /** @var View $view */
            $view = $this->getViewByRequest->__invoke(
                $fakeRequest,
                $getViewOptions
            );
        } catch (SiteNotFound $exception) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)$this->notFoundStatus,
                    $exception->getMessage(),
                    static::NAME,
                    static::SOURCE_SITE
                ),
                $this->notFoundStatus,
                [],
                BuildResponseOptions::invoke()
            );
        } catch (PageNotFound $exception) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)$this->notFoundStatus,
                    $exception->getMessage(),
                    static::NAME,
                    static::SOURCE_PAGE
                ),
                $this->notFoundStatus,
                [],
                BuildResponseOptions::invoke()
            );
        } catch (LayoutNotFound $exception) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)$this->notFoundStatus,
                    $exception->getMessage(),
                    static::NAME,
                    static::SOURCE_LAYOUT
                ),
                $this->notFoundStatus,
                [],
                BuildResponseOptions::invoke()
            );
        } catch (ThemeNotFound $exception) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    (string)$this->notFoundStatus,
                    $exception->getMessage(),
                    static::NAME,
                    static::SOURCE_THEME
                ),
                $this->notFoundStatus,
                [],
                BuildResponseOptions::invoke()
            );
        }

        return new ZrcmsJsonResponse(
            $this->viewToArray->__invoke($view),
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }
}
