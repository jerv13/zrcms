<?php

namespace Zrcms\HttpExpressive1\HttpApi\Content\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Content\Api\CmsResourceToArray;
use Zrcms\Content\Model\CmsResource;
use Zrcms\HttpExpressive1\Model\ResponseCodes;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishCmsResource
{
    const SOURCE = 'publish-cms-resource';

    /**
     * @var \Zrcms\Content\Api\Action\PublishCmsResource
     */
    protected $publishCmsResource;

    /**
     * @var CmsResourceToArray
     */
    protected $cmsResourceToArray;

    /**
     * @var GetUserIdByRequest
     */
    protected $getUserIdByRequest;

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
     * @param \Zrcms\Content\Api\Action\PublishCmsResource $publishCmsResource
     * @param CmsResourceToArray                           $cmsResourceToArray
     * @param GetUserIdByRequest                           $getUserIdByRequest
     * @param HandleResponseApi                            $handleResponseApi
     * @param string                                       $cmsResourceClass
     * @param string                                       $name
     */
    public function __construct(
        \Zrcms\Content\Api\Action\PublishCmsResource $publishCmsResource,
        CmsResourceToArray $cmsResourceToArray,
        GetUserIdByRequest $getUserIdByRequest,
        HandleResponseApi $handleResponseApi,
        string $cmsResourceClass,
        string $name
    ) {
        $this->publishCmsResource = $publishCmsResource;
        $this->cmsResourceToArray = $cmsResourceToArray;
        $this->getUserIdByRequest = $getUserIdByRequest;
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
        $properties = $request->getParsedBody();

        if (empty($properties)) {
            $response = new JsonResponse(
                null,
                400
            );

            return $this->handleResponseApi->__invoke(
                $response,
                [
                    HandleResponseOptions::API_MESSAGES => [
                        'type' => $this->name,
                        'value' => 'Data not received',
                        'source' => self::SOURCE,
                        'code' => ResponseCodes::PROPERTIES_NOT_RECEIVED,
                        'primary' => true,
                        'params' => []
                    ]
                ]
            );
        }

        /** @var CmsResource::class $cmsResourceClass */
        $cmsResourceClass = $this->cmsResourceClass;

        $cmsResource = new $cmsResourceClass(
            $properties,
            $this->getUserIdByRequest->__invoke($request),
            get_class($this)
        );

        $newCmsResource = $this->publishCmsResource->__invoke(
            $cmsResource,
            $this->getUserIdByRequest->__invoke($request),
            get_class($this)
        );

        $result = $this->cmsResourceToArray->__invoke(
            $newCmsResource
        );

        $response = new JsonResponse(
            $result
        );

        return $this->handleResponseApi->__invoke(
            $response
        );
    }
}
