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
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Reliv\ArrayProperties\Property;
use Zrcms\HttpViewRender\Request\RequestWithGetViewOptions;

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

        $showViewData = Property::getBool(
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
                BuildMessageValue::invoke(
                    (string)$this->notFoundStatus,
                    'NOT ALLOWED',
                    static::NAME,
                    static::SOURCE_ACL
                ),
                $this->notAllowedStatus,
                [],
                BuildResponseOptions::invoke()
            );
        }

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
