<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\CoreView\Api\GetViewByRequestBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithGetViewOptionPageVersionId
{
    const ATTRIBUTE_PAGE_VERSION_ID = 'zrcms-page-version-id';
    const PARAM_PAGE_VERSION_ID = 'page-version-id';

    const DEFAULT_NOT_ALLOWED_MESSAGE = 'NOT ALLOWED';
    const DEFAULT_NOT_ALLOWED_STATUS = 401;
    const DEFAULT_NOT_ALLOWED_HEADERS = ['reason-phrase' => 'NOT ALLOWED: RENDER VERSION ID'];

    protected $isAllowed;
    protected $isAllowedOptions;
    protected $notAllowedMessage;
    protected $notAllowedStatus;
    protected $notAllowedHeaders;

    /**
     * @param IsAllowed $isAllowed
     * @param array     $isAllowedOptions
     * @param string    $notAllowedMessage
     * @param int       $notAllowedStatus
     * @param array     $notAllowedHeaders
     */
    public function __construct(
        IsAllowed $isAllowed,
        array $isAllowedOptions = [],
        string $notAllowedMessage = self::DEFAULT_NOT_ALLOWED_MESSAGE,
        int $notAllowedStatus = self::DEFAULT_NOT_ALLOWED_STATUS,
        array $notAllowedHeaders = self::DEFAULT_NOT_ALLOWED_HEADERS
    ) {
        $this->isAllowed = $isAllowed;
        $this->isAllowedOptions = $isAllowedOptions;
        $this->notAllowedMessage = $notAllowedMessage;
        $this->notAllowedStatus = $notAllowedStatus;
        $this->notAllowedHeaders = $notAllowedHeaders;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return mixed
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $queryParams = $request->getQueryParams();

        $pageVersionId = Property::get(
            $queryParams,
            self::PARAM_PAGE_VERSION_ID,
            null
        );

        if ($pageVersionId === null) {
            return $next($request, $response);
        }

        $getViewOptions = (array)$request->getAttribute(
            RequestWithGetViewOptions::ATTRIBUTE_GET_VIEW_OPTIONS,
            []
        );

        $allowed = $this->isAllowed->__invoke(
            $request,
            $this->isAllowedOptions
        );

        if (!$allowed) {
            return new HtmlResponse(
                $this->notAllowedMessage,
                $this->notAllowedStatus,
                $this->notAllowedHeaders
            );
        }

        $getViewOptions[GetViewByRequestBasic::OPTION_PAGE_VERSION_ID] = (string)$pageVersionId;

        $request = $request
            ->withAttribute(
                RequestWithGetViewOptions::ATTRIBUTE_GET_VIEW_OPTIONS,
                $getViewOptions
            );

        return $next($request, $response);
    }
}
