<?php

namespace Zrcms\HttpExpressive1\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\RcmApiLib\Service\PsrResponseService;
use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use ZfInputFilterService\InputFilter\ServiceAwareInputFilter;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ZfInputFilterServiceHttp
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
     * @var PsrResponseService
     */
    protected $psrResponseService;

    /**
     * @param ServiceAwareFactory $factory
     * @param array               $inputFilterConfig
     * @param PsrResponseService  $psrResponseService
     */
    public function __construct(
        ServiceAwareFactory $factory,
        array $inputFilterConfig,
        PsrResponseService $psrResponseService
    ) {
        $this->factory = $factory;
        $this->inputFilterConfig = $inputFilterConfig;
        $this->psrResponseService = $psrResponseService;
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
            return $this->psrResponseService->getPsrApiResponse(
                $response,
                $data,
                400,
                $serviceAwareInputFilter
            );
        }

        return $next($request, $response);
    }
}
