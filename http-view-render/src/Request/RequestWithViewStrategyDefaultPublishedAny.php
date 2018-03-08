<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewDefaultPublishedAny;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithViewStrategyDefaultPublishedAny
{
    const ATTRIBUTE_VIEW_PUBLISHED_ANY = BuildViewDefaultPublishedAny::ATTRIBUTE_VIEW_PUBLISHED_ANY;

    // This comes from client
    const PARAM_VIEW_PUBLISHED_ANY = 'view-published-any';

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

        $publishedAny = Property::getBool(
            $queryParams,
            self::PARAM_VIEW_PUBLISHED_ANY
        );

        if (empty($publishedAny)) {
            return $next($request, $response);
        }

        $request = $request->withAttribute(
            self::ATTRIBUTE_VIEW_PUBLISHED_ANY,
            $publishedAny
        );

        return $next($request, $response);
    }
}
