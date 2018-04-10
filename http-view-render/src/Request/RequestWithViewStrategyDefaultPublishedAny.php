<?php

namespace Zrcms\HttpViewRender\Request;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewDefaultPublishedAny;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithViewStrategyDefaultPublishedAny implements MiddlewareInterface
{
    const ATTRIBUTE_VIEW_PUBLISHED_ANY = BuildViewDefaultPublishedAny::ATTRIBUTE_VIEW_PUBLISHED_ANY;

    // This comes from client
    const PARAM_VIEW_PUBLISHED_ANY = 'view-published-any';

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

        $publishedAny = Property::getBool(
            $queryParams,
            self::PARAM_VIEW_PUBLISHED_ANY
        );

        if (empty($publishedAny)) {
            return $delegate->process($request);
        }

        $request = $request->withAttribute(
            self::ATTRIBUTE_VIEW_PUBLISHED_ANY,
            $publishedAny
        );

        return $delegate->process($request);
    }
}
