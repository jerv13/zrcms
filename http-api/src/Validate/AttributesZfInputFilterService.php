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
        $attributes = $request->getAttributes();

        $serviceAwareInputFilter = new ServiceAwareInputFilter(
            $this->factory,
            $this->inputFilterConfig
        );

        $serviceAwareInputFilter->setData($attributes);

        if (!$serviceAwareInputFilter->isValid($attributes)) {
            return new ZrcmsJsonResponse(
                null,
                $serviceAwareInputFilter,
                400
            );
        }

        return $next($request, $response);
    }
}
