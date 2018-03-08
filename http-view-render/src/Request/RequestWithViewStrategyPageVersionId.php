<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewPageVersionId;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithViewStrategyPageVersionId
{
    const ATTRIBUTE_VIEW_PAGE_VERSION_ID = BuildViewPageVersionId::ATTRIBUTE_VIEW_PAGE_VERSION_ID;
    // This comes from client
    const PARAM_VIEW_PAGE_VERSION_ID = 'view-page-version-id';

    /**
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
        $queryParams = $request->getQueryParams();

        $pageVersionId = Property::getString(
            $queryParams,
            self::PARAM_VIEW_PAGE_VERSION_ID
        );

        if (empty($pageVersionId)) {
            return $next($request, $response);
        }

        $request = $request->withAttribute(
            self::ATTRIBUTE_VIEW_PAGE_VERSION_ID,
            $pageVersionId
        );

        return $next($request, $response);
    }
}
