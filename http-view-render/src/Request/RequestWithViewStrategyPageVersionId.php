<?php

namespace Zrcms\HttpViewRender\Request;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewPageVersionId;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithViewStrategyPageVersionId implements MiddlewareInterface
{
    const ATTRIBUTE_VIEW_PAGE_VERSION_ID = BuildViewPageVersionId::ATTRIBUTE_VIEW_PAGE_VERSION_ID;
    // This comes from client
    const PARAM_VIEW_PAGE_VERSION_ID = 'view-page-version-id';

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $queryParams = $request->getQueryParams();

        $pageVersionId = Property::getString(
            $queryParams,
            self::PARAM_VIEW_PAGE_VERSION_ID
        );

        if (empty($pageVersionId)) {
            return $delegate->process($request);
        }

        $request = $request->withAttribute(
            self::ATTRIBUTE_VIEW_PAGE_VERSION_ID,
            $pageVersionId
        );

        return $delegate->process($request);
    }
}
