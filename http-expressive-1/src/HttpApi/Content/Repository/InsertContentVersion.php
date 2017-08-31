<?php

namespace Zrcms\HttpExpressive1\HttpApi\Content\Repository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\HttpExpressive1\Model\ResponseCodes;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertContentVersion
{
    const SOURCE = 'zrcms-insert-content-version';
    /**
     * @var \Zrcms\Content\Api\Repository\InsertContentVersion
     */
    protected $insertContentVersion;

    /**
     * @var ContentVersionToArray
     */
    protected $contentVersionToArray;

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
    protected $contentVersionClass;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param \Zrcms\Content\Api\Repository\InsertContentVersion $insertContentVersion
     * @param ContentVersionToArray                              $contentVersionToArray
     * @param GetUserIdByRequest                                 $getUserIdByRequest
     * @param HandleResponseApi                                  $handleResponseApi
     * @param string                                             $contentVersionClass
     * @param string                                             $name
     */
    public function __construct(
        \Zrcms\Content\Api\Repository\InsertContentVersion $insertContentVersion,
        ContentVersionToArray $contentVersionToArray,
        GetUserIdByRequest $getUserIdByRequest,
        HandleResponseApi $handleResponseApi,
        string $contentVersionClass,
        string $name
    ) {
        $this->insertContentVersion = $insertContentVersion;
        $this->contentVersionToArray = $contentVersionToArray;
        $this->getUserIdByRequest = $getUserIdByRequest;
        $this->handleResponseApi = $handleResponseApi;
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

        /** @var ContentVersion::class $contentVersionClass */
        $contentVersionClass = $this->contentVersionClass;

        $contentVersion = new $contentVersionClass(
            $properties,
            $this->getUserIdByRequest->__invoke($request),
            get_class($this)
        );

        $newContentVersion = $this->insertContentVersion->__invoke(
            $contentVersion
        );

        $result = $this->contentVersionToArray->__invoke(
            $newContentVersion
        );

        $response = new JsonResponse(
            $result
        );

        return $this->handleResponseApi->__invoke(
            $response
        );
    }
}
