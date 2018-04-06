<?php

namespace Zrcms\HttpApi\Acl;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
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
class HttpApiIsAllowed implements MiddlewareInterface
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
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|ZrcmsJsonResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
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

        return $delegate->process($request);
    }
}
