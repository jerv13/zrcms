<?php

namespace Zrcms\HttpContent\Content;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Content\Api\Content\ContentVersionToArray;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpViewRender\Model\ResponseCodes;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertContentVersion
{
    const SOURCE = 'zrcms-insert-content-version';
    /**
     * @var \Zrcms\Content\Api\Content\InsertContentVersion
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
     * @var string
     */
    protected $contentVersionClass;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param \Zrcms\Content\Api\Content\InsertContentVersion $insertContentVersion
     * @param ContentVersionToArray                              $contentVersionToArray
     * @param GetUserIdByRequest                                 $getUserIdByRequest
     * @param string                                             $contentVersionClass
     * @param string                                             $name
     */
    public function __construct(
        \Zrcms\Content\Api\Content\InsertContentVersion $insertContentVersion,
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

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
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
