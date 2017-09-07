<?php

namespace Zrcms\HttpExpressive1\HttpAcl;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\HttpExpressive1\Model\ResponseCodes;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedCheckApi
{
    const SOURCE = 'zrcms-is-allowed-check-api';

    /**
     * @var HandleResponseApi
     */
    protected $handleResponse;

    /**
     * @var IsAllowed
     */
    protected $isAllowed;

    /**
     * @var string
     */
    protected $aclOptions;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param HandleResponseApi $handleResponse
     * @param IsAllowed         $isAllowed
     * @param array             $aclOptions
     * @param string            $name
     */
    public function __construct(
        HandleResponseApi $handleResponse,
        IsAllowed $isAllowed,
        array $aclOptions,
        string $name
    ) {
        $this->handleResponse = $handleResponse;
        $this->isAllowed = $isAllowed;
        $this->aclOptions = $aclOptions;
        $this->name = $name;
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
            $response = new JsonResponse([], 401);

            return $this->handleResponse->__invoke(
                $response->withStatus(401, 'NOT ALLOWED'),
                [
                    HandleResponseOptions::MESSAGE
                    => 'Not allowed for acl: ' . get_class($this->isAllowed)
                        . ' with options: ' . json_encode($this->aclOptions),
                    HandleResponseOptions::API_MESSAGES => [
                        'type' => $this->name,
                        'value' => 'Not allowed',
                        'source' => self::SOURCE,
                        'code' => ResponseCodes::NOT_ALLOWED,
                        'primary' => true,
                        'params' => []
                    ]
                ]
            );
        }

        return $next($request, $response);
    }
}
