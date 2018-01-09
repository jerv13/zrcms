<?php

namespace Zrcms\HttpApiView\Content;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\CoreView\Api\GetViewByRequest;
use Zrcms\CoreView\Api\ViewToArray;
use Zrcms\CoreView\Exception\LayoutNotFound;
use Zrcms\CoreView\Exception\PageNotFound;
use Zrcms\CoreView\Exception\SiteNotFound;
use Zrcms\CoreView\Exception\ThemeNotFound;
use Zrcms\CoreView\Model\View;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiGetViewDataByRequest
{
    const PARAM_VIEW_DATA = 'zrcms-view-data';
    const SOURCE_ACL = 'acl';
    const SOURCE_SITE = 'site';
    const SOURCE_PAGE = 'page';
    const SOURCE_THEME = 'theme';
    const SOURCE_LAYOUT = 'layout';
    const NAME = 'view-get-view-by-request';

    protected $isAllowed;
    protected $isAllowedOptions;
    protected $getViewByRequest;
    protected $viewToArray;
    protected $notFoundStatus;
    protected $notAllowedStatus;
    protected $debug;

    /**
     * @param IsAllowed        $isAllowed
     * @param GetViewByRequest $getViewByRequest
     * @param ViewToArray      $viewToArray
     * @param array            $isAllowedOptions
     * @param int              $notFoundStatus
     * @param int              $notAllowedStatus
     * @param bool             $debug
     */
    public function __construct(
        IsAllowed $isAllowed,
        GetViewByRequest $getViewByRequest,
        ViewToArray $viewToArray,
        array $isAllowedOptions = [],
        int $notFoundStatus = 404,
        int $notAllowedStatus = 401,
        bool $debug
    ) {
        $this->isAllowed = $isAllowed;
        $this->isAllowedOptions = $isAllowedOptions;
        $this->getViewByRequest = $getViewByRequest;
        $this->viewToArray = $viewToArray;
        $this->notFoundStatus = $notFoundStatus;
        $this->notAllowedStatus = $notAllowedStatus;
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
        $queryParams = $request->getQueryParams();

        $showViewData = Param::getBool(
            $queryParams,
            static::PARAM_VIEW_DATA,
            false
        );

        if (!$showViewData) {
            return $next($request, $response);
        }

        $allowed = $this->isAllowed->__invoke(
            $request,
            $this->isAllowedOptions
        );

        $encodingOptions = 0;

        if ($this->debug) {
            $encodingOptions = JSON_PRETTY_PRINT;
        }

        if (!$allowed) {
            $apiMessages = [
                'type' => static::NAME,
                'value' => 'NOT ALLOWED',
                'source' => static::SOURCE_ACL,
                'code' => $this->notFoundStatus,
                'primary' => true,
                'params' => []
            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                $this->notAllowedStatus,
                [],
                $encodingOptions
            );
        }

        $getViewOptions = $request->getAttribute(
            GetViewByRequest::REQUEST_ATTRIBUTE_GET_VIEW_OPTIONS,
            []
        );

        try {
            /** @var View $view */
            $view = $this->getViewByRequest->__invoke(
                $request,
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
