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
        $routeConfig = array_filter(
            $this->appConfig['routes'],
            [$this, 'filterRoutes'],
            ARRAY_FILTER_USE_BOTH
        );

        ksort($routeConfig);

        $this->swaggerConfig['host'] = $request->getUri()->getHost();
        $this->swaggerConfig['basePath'] = '/';

        $this->swaggerConfig['paths'] = $this->buildSwaggerPaths(
            $routeConfig
        );

        return new JsonResponse(
            $this->swaggerConfig,
            200,
            [],
            $this->getJsonFlags()
        );
    }

    /**
     * @param array $routeData
     * @param mixed $key
     *
     * @return bool
     */
    protected function filterRoutes($routeData, $key)
    {
        if ($this->isZrcmsApi($key, $routeData)) {
            return true;
        }

        return $this->isSwaggerRoute($key, $routeData);
    }

    /**
     * @param mixed $key
     * @param array $routeData
     *
     * @return bool
     */
    protected function isZrcmsApi(
        $key,
        array $routeData
    ) {
        $name = $this->buildRouteName(
            $key,
            $routeData
        );

        return (substr($name, 0, 10) === 'zrcms.api.');
    }

    /**
     * @param mixed $key
     * @param array $routeData
     *
     * @return bool
     */
    protected function isSwaggerRoute(
        $key,
        array $routeData
    ) {
        return array_key_exists(self::SWAGGER, $routeData);
    }

    /**
     * @param mixed $key
     * @param array $routeData
     *
     * @return null|string
     */
    protected function buildRouteName(
        $key,
        array $routeData
    ) {
        return Param::getString(
            $routeData,
            'name',
            $key
        );
    }

    /**
     * @param array $routeConfig
     *
     * @return array
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    protected function buildSwaggerPaths(
        array $routeConfig
    ): array {
        $swaggerPaths = [];

        foreach ($routeConfig as $name => $routeData) {
            $path = Param::getRequired(
                $routeData,
                'path'
            );

            $configName = $this->buildRouteName(
                $name,
                $routeData
            );
            $swaggerPathData = $this->buildSwaggerPathData($configName, $routeData);

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
     * @param array  $routeData
     *
     * @return array
     */
    protected function buildSwaggerPathData(
        string $name,
        array $routeData
    ): array {
        $swaggerPathData = [];

        $swaggerConfig = Param::getArray(
            $routeData,
            self::SWAGGER,
            []
        );

        $allowedMethods = Param::get(
            $routeData,
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
