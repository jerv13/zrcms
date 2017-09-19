<?php

namespace Zrcms\HttpExpressive1\HttpApi\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\CmsResourceToArray;
use Zrcms\Content\Api\Repository\FindContentVersion;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Content\Fields\FieldsCmsResource;
use Zrcms\Content\Fields\FieldsContentVersion;
use Zrcms\Content\Model\CmsResourceBasic;
use Zrcms\HttpExpressive1\Model\JsonApiResponse;
use Zrcms\HttpExpressive1\Model\ResponseCodes;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishCmsResource
{
    const SOURCE = 'zrcms-publish-cms-resource';

    /**
     * @var \Zrcms\Content\Api\Action\PublishCmsResource
     */
    protected $publishCmsResource;

    /**
     * @var FindContentVersion
     */
    protected $findContentVersion;

    /**
     * @var CmsResourceToArray
     */
    protected $cmsResourceToArray;

    /**
     * @var GetUserIdByRequest
     */
    protected $getUserIdByRequest;

    /**
     * @var string
     */
    protected $cmsResourceClass;

    /**
     * @var string
     */
    protected $contentVersionClass;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param \Zrcms\Content\Api\Action\PublishCmsResource $publishCmsResource
     * @param FindContentVersion                           $findContentVersion
     * @param CmsResourceToArray                           $cmsResourceToArray
     * @param GetUserIdByRequest                           $getUserIdByRequest
     * @param string                                       $cmsResourceClass
     * @param string                                       $contentVersionClass
     * @param string                                       $name
     */
    public function __construct(
        \Zrcms\Content\Api\Action\PublishCmsResource $publishCmsResource,
        FindContentVersion $findContentVersion,
        CmsResourceToArray $cmsResourceToArray,
        GetUserIdByRequest $getUserIdByRequest,
        string $cmsResourceClass,
        string $contentVersionClass,
        string $name
    ) {
        $this->publishCmsResource = $publishCmsResource;
        $this->cmsResourceToArray = $cmsResourceToArray;
        $this->findContentVersion = $findContentVersion;
        $this->getUserIdByRequest = $getUserIdByRequest;
        $this->cmsResourceClass = $cmsResourceClass;
        $this->contentVersionClass = $contentVersionClass;
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
        $requestData = $request->getParsedBody();

        if (empty($requestData)) {
            $apiMessages = [
                'type' => $this->name,
                'value' => 'Data not received',
                'source' => self::SOURCE,
                'code' => ResponseCodes::PROPERTIES_NOT_RECEIVED,
                'primary' => true,
                'params' => []
            ];

            return new JsonApiResponse(
                null,
                $apiMessages,
                400
            );
        }

        $createdByUserId = $this->getUserIdByRequest->__invoke($request);
        $createdReason = get_class($this);

        if (empty($createdByUserId)) {
            $apiMessages = [
                'type' => $this->name,
                'value' => 'Valid user required to be logged in',
                'source' => self::SOURCE,
                'code' => ResponseCodes::VALID_USER_REQUIRED,
                'primary' => true,
                'params' => []
            ];

            return new JsonApiResponse(
                null,
                $apiMessages,
                400
            );
        }

        $requestedContentVersionId = $requestData['contentVersion']['id'];

        $contentVersion = $this->findContentVersion->__invoke(
            $requestedContentVersionId
        );

        if (empty($contentVersion)) {
            $apiMessages = [
                'type' => $this->name,
                'value' => 'Not found for id: ' . $requestedContentVersionId,
                'source' => self::SOURCE,
                'code' => ResponseCodes::NOT_FOUND,
                'primary' => true,
                'params' => []
            ];

            return new JsonApiResponse(
                null,
                $apiMessages,
                404
            );
        }
        /** @var CmsResource::class $cmsResourceClass */
        $cmsResourceClass = $this->cmsResourceClass;

        $cmsResource = new $cmsResourceClass(
            $requestData['id'],
            true,
            $contentVersion,
            $requestData['properties'],
            $createdByUserId,
            $createdReason
        );

//        try {
            $newCmsResource = $this->publishCmsResource->__invoke(
                $cmsResource,
                $createdByUserId,
                $createdReason
            );
//        } catch (\Exception $exception) {
//            return new JsonApiResponse(
//                null,
//                $exception,
//                500
//            );
//        }

        $result = $this->cmsResourceToArray->__invoke(
            $newCmsResource
        );

        return new JsonApiResponse(
            $result
        );
    }
}
