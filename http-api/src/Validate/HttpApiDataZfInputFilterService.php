<?php

namespace Zrcms\HttpApi\Validate;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use ZfInputFilterService\InputFilter\ServiceAwareInputFilter;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiDataZfInputFilterService
{
    protected $factory;
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
            return new ZrcmsJsonResponse(
                null,
                $serviceAwareInputFilter,
                400
            );
        }

        return $next($request, $response);
    }
}
