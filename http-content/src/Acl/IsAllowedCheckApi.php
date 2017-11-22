<?php

namespace Zrcms\HttpContent\Acl;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Http\Response\ZrcmsJsonResponse;
use Zrcms\HttpViewRender\Model\ResponseCodes;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedCheckApi
{
    const SOURCE = 'zrcms-is-allowed-check-api';

    /**
     * @var IsAllowed
     */
    protected $isAllowed;

    /**
     * @var string
     */
    protected $aclOptions;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param IsAllowed $isAllowed
     * @param array     $aclOptions
     * @param string    $name
     */
    public function __construct(
        IsAllowed $isAllowed,
        array $aclOptions,
        string $name
    ) {
        $this->isAllowed = $isAllowed;
        $this->aclOptions = $aclOptions;
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
        if (!$this->isAllowed->__invoke($request, $this->aclOptions)) {
            $apiMessages = [
                'type' => $this->name,
                'value' => 'Not allowed',
                'source' => self::SOURCE,
                'code' => ResponseCodes::NOT_ALLOWED,
                'primary' => true,
                'params' => []

            ];
            return new ZrcmsJsonResponse(
                [],
                $apiMessages,
                401
            );
        }

        return $next($request, $response);
    }
}
