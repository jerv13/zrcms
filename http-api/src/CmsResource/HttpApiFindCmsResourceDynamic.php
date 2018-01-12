<?php

namespace Zrcms\HttpApi\CmsResource;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Core\Api\CmsResource\FindCmsResource;
use Zrcms\HttpApi\GetDynamicApiValue;
use Zrcms\HttpApi\HttpApiDynamic;
use Zrcms\InputValidation\Api\Validate;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindCmsResourceDynamic implements HttpApiDynamic
{
    const ATTRIBUTE_HTTP_TYPE = 'http-api-find-cms-resource';

    protected $serviceContainer;
    protected $getDynamicApiValue;
    protected $isAllowed;
    protected $validateAttribute;
    protected $findCmsResource;

    /**
     * @param ContainerInterface $serviceContainer
     * @param GetDynamicApiValue $getDynamicApiValue
     * @param IsAllowed          $isAllowed
     * @param Validate           $validateAttribute
     * @param FindCmsResource    $findCmsResource
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        GetDynamicApiValue $getDynamicApiValue,
        IsAllowed $isAllowed,
        Validate $validateAttribute,
        FindCmsResource $findCmsResource
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->getDynamicApiValue = $getDynamicApiValue;
        $this->isAllowed = $isAllowed,
        $this->validateAttribute = $validateAttribute,
        $this->findCmsResource = $findCmsResource;
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
        $httpApiName = $request->getAttribute(static::ATTRIBUTE_HTTP_NAME);
        $httpApiType = $request->getAttribute(static::ATTRIBUTE_HTTP_TYPE);

        $isAllowedConfig = $this->getDynamicApiValue->__invoke(
            $httpApiName,
            $httpApiType,
            static::ACL,
            []
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $isAllowedConfig
     *
     * @return bool
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function isAllowed(
        ServerRequestInterface $request,
        array $isAllowedConfig
    ): bool {
        $isAllowed = $this->isAllowed;

        $isAllowedServiceName = Param::getString(
            $isAllowedConfig,
            'isAllowed'
        );

        if ($isAllowedServiceName !== null) {
            /** @var IsAllowed $isAllowed */
            $isAllowed = $this->serviceContainer->get($isAllowedServiceName);
        }

        if (!$isAllowed instanceof IsAllowed) {
            throw new \Exception();
        }

        $isAllowedOptions = Param::getArray(
            $isAllowedConfig,
            'isAllowedOptions',
            []
        );

        return $isAllowed->__invoke(
            $request,
            $isAllowedOptions
        );
    }
}
