<?php

namespace Zrcms\HttpApi\Acl;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Http\Api\BuildMessageValue;
use Zrcms\Http\Api\BuildResponseOptions;
use Zrcms\Http\Model\ResponseCodes;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiIsAllowed
{
    const SOURCE = 'zrcms-http-is-allowed';

    const DEFAULT_NOT_ALLOWED_STATUS = 401;

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
        int $notAllowedStatus = self::DEFAULT_NOT_ALLOWED_STATUS,
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
            return new ZrcmsJsonResponse(
                null,
                BuildMessageValue::invoke(
                    ResponseCodes::NOT_ALLOWED,
                    'Not allowed',
                    $this->name,
                    self::SOURCE
                ),
                $this->notAllowedStatus,
                [],
                BuildResponseOptions::invoke()
            );
        }

        return $next($request, $response);
    }
}
