<?php

namespace Zrcms\HttpExpressive1\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Acl\Api\IsAllowed;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AclHttp
{
    /**
     * @var IsAllowed
     */
    protected $isAllowed;

    /**
     * @var string
     */
    protected $resourceId;

    /**
     * @var null|string
     */
    protected $privilege;

    /**
     * @param IsAllowed $isAllowed
     * @param string    $resourceId
     * @param null      $privilege
     */
    public function __construct(
        IsAllowed $isAllowed,
        string $resourceId,
        $privilege = null
    ) {
        $this->isAllowed = $isAllowed;
        $this->resourceId = $resourceId;
        $this->privilege = $privilege;
    }

    /**
     * __invoke
     *
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
        if (!$this->isAllowed->__invoke($request, $this->resourceId, $this->privilege)) {

        }
    }
}
