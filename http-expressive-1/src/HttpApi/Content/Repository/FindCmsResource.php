<?php

namespace Zrcms\HttpExpressive1\HttpApi\Content\Repository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Content\Api\CmsResourceToArray;
use Zrcms\Content\Model\PropertiesCmsResource;
use Zrcms\HttpExpressive1\Model\ResponseCodes;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindCmsResource
{
    const SOURCE = 'zrcms-find-cms-resource';

    /**
     * @var \Zrcms\Content\Api\Repository\FindCmsResource
     */
    protected $findCmsResource;

    /**
     * @var CmsResourceToArray
     */
    protected $cmsResourceToArray;

    /**
     * @var HandleResponseApi
     */
    protected $handleResponseApi;

    /**
     * @var string
     */
    protected $cmsResourceClass;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param \Zrcms\Content\Api\Repository\FindCmsResource $findCmsResource
     * @param CmsResourceToArray                            $cmsResourceToArray
     * @param HandleResponseApi                             $handleResponseApi
     * @param string                                        $cmsResourceClass
     * @param string                                        $name
     */
    public function __construct(
        \Zrcms\Content\Api\Repository\FindCmsResource $findCmsResource,
        CmsResourceToArray $cmsResourceToArray,
        HandleResponseApi $handleResponseApi,
        string $cmsResourceClass,
        string $name
    ) {
        $this->findCmsResource = $findCmsResource;
        $this->cmsResourceToArray = $cmsResourceToArray;
        $this->handleResponseApi = $handleResponseApi;
        $this->cmsResourceClass = $cmsResourceClass;
        $this->name = $name;
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
        $cmsResourceId = (string)$request->getAttribute(
            PropertiesCmsResource::ID
        );

        if (empty($cmsResourceId)) {
            $response = new JsonResponse(
                null,
                400
            );

            return $this->handleResponseApi->__invoke(
                $response,
                [
                    HandleResponseOptions::API_MESSAGES => [
                        'type' => $this->name,
                        'value' => 'ID not received',
                        'source' => self::SOURCE,
                        'code' => ResponseCodes::ID_NOT_RECEIVED,
                        'primary' => true,
                        'params' => []
                    ]
                ]
            );
        }

        $cmsResource = $this->findCmsResource->__invoke(
            $cmsResourceId
        );

        if (empty($cmsResource)) {
            $response = new JsonResponse(
                false,
                400
            );

            return $this->handleResponseApi->__invoke(
                $response,
                [
                    HandleResponseOptions::API_MESSAGES => [
                        'type' => $this->name,
                        'value' => 'Update failed',
                        'source' => self::SOURCE,
                        'code' => ResponseCodes::FAILED,
                        'primary' => true,
                        'params' => []
                    ]
                ]
            );
        }

        $result = $this->cmsResourceToArray->__invoke(
            $cmsResource
        );

        $response = new JsonResponse(
            $result
        );

        return $this->handleResponseApi->__invoke(
            $response
        );
    }
}
