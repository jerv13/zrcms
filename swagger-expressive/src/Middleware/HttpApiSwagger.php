<?php

namespace Zrcms\SwaggerExpressive\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\SwaggerExpressive\Api\BuildRouteName;
use Zrcms\SwaggerExpressive\Api\IsSwaggerRoute;
use Zrcms\SwaggerExpressive\ConfigKey;
use Zrcms\SwaggerExpressive\Options;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiSwagger
{
    const SWAGGER = ConfigKey::SWAGGER;

    protected $appConfig;
    protected $swaggerConfig;
    protected $isSwaggerRoute;
    protected $debug;

    /**
     * @param array          $appConfig
     * @param array          $swaggerConfig
     * @param IsSwaggerRoute $isSwaggerRoute
     * @param bool           $debug
     */
    public function __construct(
        array $appConfig,
        array $swaggerConfig,
        IsSwaggerRoute $isSwaggerRoute,
        bool $debug = false
    ) {
        $this->appConfig = $appConfig;
        $this->swaggerConfig = $swaggerConfig;
        $this->isSwaggerRoute = $isSwaggerRoute;
        $this->debug = $debug;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return JsonResponse
     * @throws \Exception
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
        return $this->isSwaggerRoute->__invoke($key, $routeData);
    }

    /**
     * @param array $routeConfig
     *
     * @return array
     * @throws \Exception
     */
    protected function buildSwaggerPaths(
        array $routeConfig
    ): array {
        $swaggerPaths = [];

        foreach ($routeConfig as $key => $routeData) {
            $path = Options::getString(
                $routeData,
                'path'
            );

            if (empty($path)) {
                throw new \Exception(
                    'Path is required in route config'
                );
            }

            $configName = BuildRouteName::invoke(
                $key,
                $routeData
            );
            $swaggerPathData = $this->buildSwaggerPathData($configName, $routeData);

            $swaggerPathData['operationId'] = Options::getString(
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

        $swaggerConfig = Options::getArray(
            $routeData,
            self::SWAGGER,
            []
        );

        $allowedMethods = Options::getArray(
            $routeData,
            'allowed_methods',
            []
        );

        if (is_string($allowedMethods)) {
            $allowedMethods = [$allowedMethods];
        }

        foreach ($allowedMethods as $allowedMethod) {
            $allowedMethod = strtolower($allowedMethod);

            $data = Options::getArray(
                $swaggerConfig,
                $allowedMethod,
                []
            );

            $data['description'] = Options::getString(
                $data,
                'description',
                'Name: ' . $name
            );

            $data['produces'] = Options::getArray(
                $data,
                'produces',
                ['application/json']
            );

            $data['parameters'] = Options::getArray(
                $data,
                'parameters',
                []
            );

            $data['responses'] = Options::getArray(
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
