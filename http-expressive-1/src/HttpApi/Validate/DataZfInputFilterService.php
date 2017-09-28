<?php

namespace Zrcms\HttpExpressive1\HttpApi\Validate;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use ZfInputFilterService\InputFilter\ServiceAwareInputFilter;
use Zrcms\HttpExpressive1\Http\JsonApiResponse;

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
     * @param ServiceAwareFactory $factory
     * @param array               $inputFilterConfig
     */
    public function __construct(
        ServiceAwareFactory $factory,
        array $inputFilterConfig
    ) {
        $this->factory = $factory;
        $this->inputFilterConfig = $inputFilterConfig;
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
        $requestData = $request->getParsedBody();

        $serviceAwareInputFilter = new ServiceAwareInputFilter(
            $this->factory,
            $this->inputFilterConfig
        );

        $serviceAwareInputFilter->setData($requestData);

        if (!$serviceAwareInputFilter->isValid($requestData)) {
            return new JsonApiResponse(
                null,
                $serviceAwareInputFilter,
                400
            );
        }

        return $next($request, $response);
    }
}
