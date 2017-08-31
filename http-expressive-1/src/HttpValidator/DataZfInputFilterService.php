<?php

namespace Zrcms\HttpExpressive1\HttpValidator;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use ZfInputFilterService\InputFilter\ServiceAwareInputFilter;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DataZfInputFilterService
{
    /**
     * @var ServiceAwareFactory
     */
    protected $factory;

    /**
     * @var array
     */
    protected $inputFilterConfig;

    /**
     * @var HandleResponseApi
     */
    protected $handleResponse;

    /**
     * @param ServiceAwareFactory $factory
     * @param array               $inputFilterConfig
     * @param HandleResponseApi   $handleResponse
     */
    public function __construct(
        ServiceAwareFactory $factory,
        array $inputFilterConfig,
        HandleResponseApi $handleResponse
    ) {
        $this->factory = $factory;
        $this->inputFilterConfig = $inputFilterConfig;
        $this->handleResponse = $handleResponse;
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
        $data = $request->getParsedBody();

        $serviceAwareInputFilter = new ServiceAwareInputFilter(
            $this->factory,
            $this->inputFilterConfig
        );

        $serviceAwareInputFilter->setData($data);

        if (!$serviceAwareInputFilter->isValid($data)) {
            $response = new JsonResponse(
                null,
                400
            );

            return $this->handleResponse->__invoke(
                $response,
                [
                    HandleResponseOptions::API_MESSAGES => $serviceAwareInputFilter
                ]
            );
        }

        return $next($request, $response);
    }
}
