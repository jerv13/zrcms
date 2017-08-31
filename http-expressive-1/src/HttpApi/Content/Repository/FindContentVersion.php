<?php

namespace Zrcms\HttpExpressive1\HttpApi\Content\Repository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\HttpExpressive1\Model\ResponseCodes;
use Zrcms\HttpResponseHandler\Api\HandleResponseApi;
use Zrcms\HttpResponseHandler\Model\HandleResponseOptions;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentVersion
{
    const SOURCE = 'find-content-version';
    /**
     * @var \Zrcms\Content\Api\Repository\FindContentVersion
     */
    protected $findContentVersion;

    /**
     * @var ContentVersionToArray
     */
    protected $contentVersionToArray;

    /**
     * @var HandleResponseApi
     */
    protected $handleResponseApi;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param \Zrcms\Content\Api\Repository\FindContentVersion $findContentVersion
     * @param ContentVersionToArray                            $contentVersionToArray
     * @param HandleResponseApi                                $handleResponseApi
     * @param string                                           $name
     */
    public function __construct(
        \Zrcms\Content\Api\Repository\FindContentVersion $findContentVersion,
        ContentVersionToArray $contentVersionToArray,
        HandleResponseApi $handleResponseApi,
        string $name
    ) {
        $this->findContentVersion = $findContentVersion;
        $this->contentVersionToArray = $contentVersionToArray;
        $this->handleResponseApi = $handleResponseApi;
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
        $contentVersionId = $request->getAttribute('id');

        if (empty($contentVersionId)) {
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

        $contentVersion = $this->findContentVersion->__invoke(
            $contentVersionId
        );

        if (empty($contentVersion)) {
            $response = new JsonResponse(
                null,
                404
            );

            return $this->handleResponseApi->__invoke(
                $response,
                [
                    HandleResponseOptions::API_MESSAGES => [
                        'type' => $this->name,
                        'value' => 'Not found for id: ' . $contentVersionId,
                        'source' => self::SOURCE,
                        'code' => ResponseCodes::NOT_FOUND,
                        'primary' => true,
                        'params' => []
                    ]
                ]
            );
        }

        $result = $this->contentVersionToArray->__invoke(
            $contentVersion
        );

        $response = new JsonResponse(
            $result
        );

        return $this->handleResponseApi->__invoke(
            $response
        );
    }
}
