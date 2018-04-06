<?php

namespace Zrcms\HttpApi\Content;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\Core\Api\Content\InsertContentVersion;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Model\ResponseCodes;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @deprecated
 *
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiInsertContentVersion implements MiddlewareInterface
{
    const SOURCE = 'zrcms-insert-content-version';

    protected $insertContentVersion;
    protected $contentVersionToArray;
    protected $getUserIdByRequest;
    protected $contentVersionClass;
    protected $name;

    /**
     * @param InsertContentVersion  $insertContentVersion
     * @param ContentVersionToArray $contentVersionToArray
     * @param GetUserIdByRequest    $getUserIdByRequest
     * @param string                $contentVersionClass
     * @param string                $name
     */
    public function __construct(
        InsertContentVersion $insertContentVersion,
        ContentVersionToArray $contentVersionToArray,
        GetUserIdByRequest $getUserIdByRequest,
        string $contentVersionClass,
        string $name
    ) {
        $this->insertContentVersion = $insertContentVersion;
        $this->contentVersionToArray = $contentVersionToArray;
        $this->getUserIdByRequest = $getUserIdByRequest;
        $this->contentVersionClass = $contentVersionClass;
        $this->name = $name;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|ZrcmsJsonResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $requestData = $request->getParsedBody();

        if (empty($requestData)) {
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    ResponseCodes::PROPERTIES_NOT_RECEIVED,
                    'Data not received',
                    $this->name,
                    self::SOURCE
                ),
                400
            );
        }

        /** @var ContentVersion::class $contentVersionClass */
        $contentVersionClass = $this->contentVersionClass;

        $contentVersion = new $contentVersionClass(
            $requestData,
            $this->getUserIdByRequest->__invoke($request),
            get_class($this)
        );

        $newContentVersion = $this->insertContentVersion->__invoke(
            $contentVersion
        );

        $result = $this->contentVersionToArray->__invoke(
            $newContentVersion
        );

        return new ZrcmsJsonResponse(
            $result
        );
    }
}
