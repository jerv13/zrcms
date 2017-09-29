<?php

namespace Zrcms\HttpExpressive\HttpApi\Repository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\HttpExpressive\Http\JsonApiResponse;
use Zrcms\HttpExpressive\Model\ResponseCodes;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentVersion
{
    const SOURCE = 'zrcms-find-content-version';
    /**
     * @var \Zrcms\Content\Api\Repository\FindContentVersion
     */
    protected $findContentVersion;

    /**
     * @var ContentVersionToArray
     */
    protected $contentVersionToArray;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param \Zrcms\Content\Api\Repository\FindContentVersion $findContentVersion
     * @param ContentVersionToArray                            $contentVersionToArray
     * @param string                                           $name
     */
    public function __construct(
        \Zrcms\Content\Api\Repository\FindContentVersion $findContentVersion,
        ContentVersionToArray $contentVersionToArray,
        string $name
    ) {
        $this->findContentVersion = $findContentVersion;
        $this->contentVersionToArray = $contentVersionToArray;
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
        $requestedContentVersionId = $request->getAttribute('id');

        if (empty($requestedContentVersionId)) {
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

        $result = $this->contentVersionToArray->__invoke(
            $contentVersion
        );

        return new JsonResponse(
            $result
        );
    }
}
