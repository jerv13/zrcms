<?php

namespace Zrcms\HttpExpressive1\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\HttpResponseHandler\Api\HandleResponse;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AclHttp
{
    /**
     * @var HandleResponse
     */
    protected $handleResponse;

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
     * @param HandleResponse $handleResponse
     * @param IsAllowed      $isAllowed
     * @param array          $aclOptions
     */
    public function __construct(
        HandleResponse $handleResponse,
        IsAllowed $isAllowed,
        array $aclOptions
    ) {
        $this->handleResponse = $handleResponse;
        $this->isAllowed = $isAllowed;
        $this->aclOptions = $aclOptions;
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
        if (!$this->isAllowed->__invoke($request, $this->aclOptions)) {
            $response = new HtmlResponse('NOT ALLOWED');

            return $this->handleResponse->__invoke(
                $request,
                $response->withStatus(401, 'NOT ALLOWED'),
                [
                    HandleResponseOptions::MESSAGE
                    => 'Not allowed for resource: ' . json_encode($this->resourceId)
                        . ' with privilege: ' . json_encode($this->privilege)
                ]
            );
        }

        return $next($request, $response);
    }
}
