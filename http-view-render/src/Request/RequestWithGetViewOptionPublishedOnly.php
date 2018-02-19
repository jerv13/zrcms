<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\CoreView\Api\GetViewByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithGetViewOptionPublishedOnly
{
    protected $isAllowed;
    protected $isAllowedOptions;

    /**
     * @param IsAllowed $isAllowed
     * @param array     $isAllowedOptions
     */
    public function __construct(
        IsAllowed $isAllowed,
        array $isAllowedOptions = []
    ) {
        $this->isAllowed = $isAllowed;
        $this->isAllowedOptions = $isAllowedOptions;
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
        $getViewOptions = (array)$request->getAttribute(
            RequestWithGetViewOptions::ATTRIBUTE_GET_VIEW_OPTIONS,
            []
        );

        $getViewOptions[GetViewByRequest::OPTION_PUBLISHED_ONLY] = !$this->isAllowed->__invoke(
            $request,
            $this->isAllowedOptions
        );

        $request = $request
            ->withAttribute(
                RequestWithGetViewOptions::ATTRIBUTE_GET_VIEW_OPTIONS,
                $getViewOptions
            );

        return $next($request, $response);
    }
}
