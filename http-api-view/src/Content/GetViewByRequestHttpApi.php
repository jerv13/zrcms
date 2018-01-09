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
class GetViewByRequestHttpApi
{
    const PARAM_VIEW_DATA = 'zrcms-view-data';
    const CODE_ACL = 'acl';
    const CODE_SITE = 'site';
    const CODE_PAGE = 'page';
    const CODE_THEME = 'theme';
    const CODE_LAYOUT = 'layout';
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
     * @return JsonResponse|ZrcmsJsonResponse
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

        if (!$allowed) {
            return new ZrcmsJsonResponse(
                null,
                static::CODE_ACL,
                $this->notAllowedStatus
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
            return new ZrcmsJsonResponse(
                null,
                static::CODE_SITE,
                $this->notFoundStatus
            );
        } catch (PageNotFound $exception) {
            return new ZrcmsJsonResponse(
                null,
                static::CODE_PAGE,
                $this->notFoundStatus
            );
        } catch (LayoutNotFound $exception) {
            return new ZrcmsJsonResponse(
                null,
                static::CODE_LAYOUT,
                $this->notFoundStatus
            );
        } catch (ThemeNotFound $exception) {
            return new ZrcmsJsonResponse(
                null,
                static::CODE_THEME,
                $this->notFoundStatus
            );
        }
        $encodingOptions = 0;

        if ($this->debug) {
            $encodingOptions = JSON_PRETTY_PRINT;
        }

        return new JsonResponse(
            $this->viewToArray->__invoke($view),
            200,
            [],
            $encodingOptions
        );
    }
}
