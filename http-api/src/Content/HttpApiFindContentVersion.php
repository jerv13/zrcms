<?php

namespace Zrcms\HttpApi\Content;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Api\Content\FindContentVersion;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Model\ResponseCodes;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindContentVersion
{
    const SOURCE = 'zrcms-find-content-version';

    protected $findContentVersion;
    protected $contentVersionToArray;
    protected $name;

    /**
     * @param FindContentVersion    $findContentVersion
     * @param ContentVersionToArray $contentVersionToArray
     * @param string                $name
     */
    public function __construct(
        FindContentVersion $findContentVersion,
        ContentVersionToArray $contentVersionToArray,
        string $name
    ) {
        $this->findContentVersion = $findContentVersion;
        $this->contentVersionToArray = $contentVersionToArray;
        $this->name = $name;
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
        $requestedContentVersionId = $request->getAttribute('id');

        if (empty($requestedContentVersionId)) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    ResponseCodes::ID_NOT_RECEIVED,
                    'ID not received',
                    $this->name,
                    self::SOURCE
                ),
                400
            );
        }

        $contentVersion = $this->findContentVersion->__invoke(
            $requestedContentVersionId
        );

        if (empty($contentVersion)) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    ResponseCodes::NOT_FOUND,
                    'Not found for id: ' . $requestedContentVersionId,
                    $this->name,
                    self::SOURCE
                ),
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
