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
use Zrcms\Http\Response\ZrcmsJsonResponse;

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

        $encodingOptions = 0;

        if ($this->debug) {
            $encodingOptions = JSON_PRETTY_PRINT;
        }

        $path = '/' . $path;

        if (empty($host)) {
            $apiMessages = [
                'type' => static::NAME,
                'value' => 'BAD REQUEST',
                'source' => static::SOURCE_MISSING_HOST,
                'code' => $this->badRequestStatus,
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                $this->notFoundStatus,
                [],
                $encodingOptions
            );
        }

        $getViewOptions = $request->getAttribute(
            GetViewByRequest::REQUEST_ATTRIBUTE_GET_VIEW_OPTIONS,
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
            $apiMessages = [
                'type' => static::NAME,
                'value' => $exception->getMessage(),
                'source' => static::SOURCE_SITE,
                'code' => $this->notFoundStatus,
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                $this->notFoundStatus,
                [],
                $encodingOptions
            );
        } catch (PageNotFound $exception) {
            $apiMessages = [
                'type' => static::NAME,
                'value' => $exception->getMessage(),
                'source' => static::SOURCE_PAGE,
                'code' => $this->notFoundStatus,
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                $this->notFoundStatus,
                [],
                $encodingOptions
            );
        } catch (LayoutNotFound $exception) {
            $apiMessages = [
                'type' => static::NAME,
                'value' => $exception->getMessage(),
                'source' => static::SOURCE_LAYOUT,
                'code' => $this->notFoundStatus,
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                $this->notFoundStatus,
                [],
                $encodingOptions
            );
        } catch (ThemeNotFound $exception) {
            $apiMessages = [
                'type' => static::NAME,
                'value' => $exception->getMessage(),
                'source' => static::SOURCE_THEME,
                'code' => $this->notFoundStatus,
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                $this->notFoundStatus,
                [],
                $encodingOptions
            );
        }

        return new ZrcmsJsonResponse(
            $this->viewToArray->__invoke($view),
            null,
            200,
            [],
            $encodingOptions
        );
    }
}
