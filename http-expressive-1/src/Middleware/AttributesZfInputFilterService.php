<?php

namespace Zrcms\HttpExpressive1\Middleware;

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
class AttributesZfInputFilterService
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
        $attributes = $request->getAttributes();

        $serviceAwareInputFilter = new ServiceAwareInputFilter(
            $this->factory,
            $this->inputFilterConfig
        );

        $serviceAwareInputFilter->setData($attributes);

        if (!$serviceAwareInputFilter->isValid($attributes)) {
            $response = new JsonResponse(
                null,
                400
            );

            return $this->handleResponse->__invoke(
                $request,
                $response,
                $next,
                [
                    HandleResponseOptions::API_MESSAGES => $serviceAwareInputFilter
                ]
            );
        }

        return $next($request, $response);
    }
}
