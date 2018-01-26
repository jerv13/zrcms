<?php

namespace Zrcms\HttpApiSwagger\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiSwagger
{
    const SWAGGER = 'swagger';

    protected $appConfig;
    protected $swaggerConfig;
    protected $debug;

    /**
     * @param array $appConfig
     * @param array $swaggerConfig
     * @param bool  $debug
     */
    public function __construct(
        array $appConfig,
        array $swaggerConfig,
        bool $debug = false
    ) {
        $this->appConfig = $appConfig;
        $this->swaggerConfig = $swaggerConfig;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return JsonResponse
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $routeConfig = $this->appConfig['routes'];

        $zrcmsRoutes = array_filter(
            $routeConfig,
            function ($value, $key) {
                return (substr($key, 0, 10) === 'zrcms.api.');
            },
            ARRAY_FILTER_USE_BOTH
        );

        $this->swaggerConfig['host'] = $request->getUri()->getHost();
        $this->swaggerConfig['basePath'] = '/zrcms/api';

        $this->swaggerConfig['paths'] = $this->buildSwaggerPaths(
            $zrcmsRoutes
        );

        return new JsonResponse(
            $this->swaggerConfig,
            200,
            [],
            $this->getJsonFlags()
        );
    }

    /**
     * @param array $zrcmsRoutes
     *
     * @return array
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    protected function buildSwaggerPaths(
        array $zrcmsRoutes
    ): array {
        $swaggerPaths = [];

        foreach ($zrcmsRoutes as $name => $zrcmsRoute) {
            $path = Param::getRequired(
                $zrcmsRoute,
                'path'
            );

            $configName = Param::getString(
                $zrcmsRoute,
                'name',
                $name
            );

            $swaggerPathData = $this->buildSwaggerPathData($configName, $zrcmsRoute);

            $swaggerPathData['operationId'] = Param::getString(
                $swaggerPathData,
                'operationId',
                $configName
            );

            $swaggerPaths[$path] = $swaggerPathData;
        }

        return $swaggerPaths;
    }

    /**
     * @param string $name
     * @param array  $zrcmsRoute
     *
     * @return array
     */
    protected function buildSwaggerPathData(
        string $name,
        array $zrcmsRoute
    ): array {
        $swaggerPathData = [];

        $swaggerConfig = Param::getArray(
            $zrcmsRoute,
            self::SWAGGER,
            []
        );

        $allowedMethods = Param::get(
            $zrcmsRoute,
            'allowed_methods',
            []
        );

        if (is_string($allowedMethods)) {
            $allowedMethods = [$allowedMethods];
        }

        foreach ($allowedMethods as $allowedMethod) {
            $allowedMethod = strtolower($allowedMethod);

            $data = Param::get(
                $swaggerConfig,
                $allowedMethod,
                []
            );

            $data['description'] = Param::getString(
                $data,
                'description',
                'Name: ' . $name
            );

            $data['produces'] = Param::getArray(
                $data,
                'produces',
                ['application/json']
            );

            $data['parameters'] = Param::getArray(
                $data,
                'parameters',
                []
            );

            $data['responses'] = Param::getArray(
                $data,
                'responses',
                []
            );
            $swaggerPathData[$allowedMethod] = $data;
        }

        return $swaggerPathData;
    }

    /**
     * @return int
     */
    public function getJsonFlags()
    {
        if ($this->debug) {
            return JSON_PRETTY_PRINT | JsonResponse::DEFAULT_JSON_FLAGS;
        }

        return JsonResponse::DEFAULT_JSON_FLAGS;
    }
}
