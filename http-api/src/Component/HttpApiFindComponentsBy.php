<?php

namespace Zrcms\HttpApi\Component;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Component\ComponentsToArray;
use Zrcms\Core\Api\Component\FindComponentsBy;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Model\HttpLimit;
use Zrcms\Http\Model\HttpOffset;
use Zrcms\Http\Model\HttpOrderBy;
use Zrcms\Http\Model\HttpWhere;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindComponentsBy
{
    const SOURCE = 'zrcms-find-components-by';

    protected $findComponentsBy;
    protected $componentsToArray;

    /**
     * @param FindComponentsBy  $findComponentsBy
     * @param ComponentsToArray $componentsToArray
     */
    public function __construct(
        FindComponentsBy $findComponentsBy,
        ComponentsToArray $componentsToArray
    ) {
        $this->findComponentsBy = $findComponentsBy;
        $this->componentsToArray = $componentsToArray;
    }

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
        $criteria = $request->getAttribute(HttpWhere::ATTRIBUTE, []);
        $orderBy = $request->getAttribute(HttpOrderBy::ATTRIBUTE);
        $limit = $request->getAttribute(HttpLimit::ATTRIBUTE);
        $offset = $request->getAttribute(HttpOffset::ATTRIBUTE);

        $components = $this->findComponentsBy->__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset
        );

        return new ZrcmsJsonResponse(
            $this->componentsToArray->__invoke($components),
            null,
            200,
            [],
            BuildResponseOptions::invoke()
        );
    }
}
