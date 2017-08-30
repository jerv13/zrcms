<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\RcmApiLib\Service\PsrResponseService;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseApiMessages implements HandleResponseApi
{
    /**
     * @var PsrResponseService
     */
    protected $psrResponseService;

    /**
     * @var array
     */
    protected $successStatuses = [];

    /**
     * @param PsrResponseService $psrResponseService
     * @param array              $successStatuses
     */
    public function __construct(
        PsrResponseService $psrResponseService,
        array $successStatuses = [200]
    ) {

        $this->psrResponseService = $psrResponseService;
        $this->successStatuses = $successStatuses;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     * @param array                  $options
     *
     * @return mixed
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null,
        array $options = []
    ) {
        $status = $response->getStatusCode();
        if (in_array($status, $this->successStatuses)) {
            return $response;
        }

        // @todo if not API response, return $next($request, $response);

        $apiMessagesData = Param::get(
            $options,
            HandleResponseOptions::API_MESSAGES,
            null
        );

        $data = null;

        if (method_exists($response, 'getPayload')) {
            $data = $response->getPayload();
        }

        $data = Param::get(
            $options,
            HandleResponseOptions::DATA,
            $data
        );

        return $this->psrResponseService->getPsrApiResponse(
            $response,
            $data,
            $status,
            $apiMessagesData
        );
    }
}
