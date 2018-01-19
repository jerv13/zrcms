<?php

namespace Zrcms\HttpApi\Acl;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Http\Model\ResponseCodes;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowed
{
    const SOURCE = 'zrcms-is-allowed-check-api';

    protected $isAllowed;
    protected $isAllowedOptions;
    protected $name;
    protected $notAllowedStatus;
    protected $debug;

    /**
     * @param IsAllowed $isAllowed
     * @param array     $isAllowedOptions
     * @param string    $name
     * @param int       $notAllowedStatus
     * @param bool      $debug
     */
    public function __construct(
        IsAllowed $isAllowed,
        array $isAllowedOptions,
        string $name,
        int $notAllowedStatus = 401,
        bool $debug = false
    ) {
        $this->isAllowed = $isAllowed;
        $this->isAllowedOptions = $isAllowedOptions;
        $this->name = $name;
        $this->notAllowedStatus = $notAllowedStatus;
        $this->debug = $debug;
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
        if (!$this->isAllowed->__invoke($request, $this->isAllowedOptions)) {
            $encodingOptions = 0;

            if ($this->debug) {
                $encodingOptions = JSON_PRETTY_PRINT;
            }

            $apiMessages = [
                'type' => $this->name,
                'message' => 'Not allowed',
                'source' => self::SOURCE,
                'code' => ResponseCodes::NOT_ALLOWED,
                'primary' => true,
                'params' => []

            ];

            return new ZrcmsJsonResponse(
                null,
                $apiMessages,
                $this->notAllowedStatus,
                [],
                [
                    ZrcmsJsonResponse::OPTION_JSON_FLAGS => $encodingOptions
                ]
            );
        }

        return $next($request, $response);
    }
}
