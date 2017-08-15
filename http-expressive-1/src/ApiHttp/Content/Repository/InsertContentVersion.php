<?php

namespace Zrcms\HttpExpressive1\ApiHttp\Content\Repository;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\RcmApiLib\Http\PsrApiResponse;
use Reliv\RcmApiLib\Model\ApiMessage;
use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\HttpExpressive1\Model\ResponseCodes;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class InsertContentVersion
{
    const SOURCE = 'insert-content-version';
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
     * @param string                                             $contentVersionClass
     * @param string                                             $name
     */
    public function __construct(
        \Zrcms\Content\Api\Repository\InsertContentVersion $insertContentVersion,
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
        $properties = $request->getParsedBody();

        // @todo input validations
        if (empty($properties)) {
            return new PsrApiResponse(
                null,
                [
                    new ApiMessage(
                        $this->name,
                        'Data not received',
                        self::SOURCE,
                        ResponseCodes::PROPERTIES_NOT_RECEIVED,
                        true
                    )
                ],
                400
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

        return new PsrApiResponse(
            $result
        );
    }
}
