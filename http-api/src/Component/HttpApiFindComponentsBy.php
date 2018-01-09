<?php

namespace Zrcms\HttpApi\Component;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Api\Component\FindComponentsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindComponentsBy
{
    protected $findComponentsBy;
    protected $componentToArray;
    protected $name;

    /**
     * @param FindComponentsBy $findComponentsBy
     * @param ComponentToArray $componentToArray
     * @param string           $name
     */
    public function __construct(
        FindComponentsBy $findComponentsBy,
        ComponentToArray $componentToArray,
        string $name
    ) {
        $this->findComponentsBy = $findComponentsBy;
        $this->componentToArray = $componentToArray;
        $this->name = $name;
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
        // @todo Write me
    }
}
