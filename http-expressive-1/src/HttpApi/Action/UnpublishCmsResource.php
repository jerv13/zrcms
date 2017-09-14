<?php

namespace Zrcms\HttpExpressive1\HttpApi\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Model\PropertiesCmsResource;
use Zrcms\HttpExpressive1\Model\JsonApiResponse;
use Zrcms\HttpExpressive1\Model\ResponseCodes;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UnpublishCmsResource
{
    const SOURCE = 'zrcms-unpublish-cms-resource';

    /**
     * @var \Zrcms\Content\Api\Action\UnpublishCmsResource
     */
    protected $unpublishCmsResource;

    /**
     * @var GetUserIdByRequest
     */
    protected $getUserIdByRequest;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param \Zrcms\Content\Api\Action\UnpublishCmsResource $unpublishCmsResource
     * @param GetUserIdByRequest                             $getUserIdByRequest
     * @param string                                         $name
     */
    public function __construct(
        \Zrcms\Content\Api\Action\UnpublishCmsResource $unpublishCmsResource,
        GetUserIdByRequest $getUserIdByRequest,
        string $name
    ) {
        $this->unpublishCmsResource = $unpublishCmsResource;
        $this->getUserIdByRequest = $getUserIdByRequest;
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
            $apiMessages = [
                'type' => $this->name,
                'value' => 'ID not received',
                'source' => self::SOURCE,
                'code' => ResponseCodes::ID_NOT_RECEIVED,
                'primary' => true,
                'params' => []
            ];

            return new JsonApiResponse(
                null,
                $apiMessages,
                400
            );
        }

        $success = $this->unpublishCmsResource->__invoke(
            $cmsResourceId,
            $this->getUserIdByRequest->__invoke($request),
            get_class($this)
        );

        if (!$success) {
            $apiMessages = [
                'type' => $this->name,
                'value' => 'Update failed',
                'source' => self::SOURCE,
                'code' => ResponseCodes::FAILED,
                'primary' => true,
                'params' => []
            ];

            return new JsonApiResponse(
                false,
                $apiMessages,
                400
            );
        }

        return new JsonApiResponse(
            $success
        );
    }
}
