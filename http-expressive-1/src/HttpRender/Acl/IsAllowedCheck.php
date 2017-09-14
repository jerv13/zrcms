<?php

namespace Zrcms\HttpExpressive1\HttpRender;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Acl\Api\IsAllowed;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsAllowedCheck
{
    const SOURCE = 'zrcms-is-allowed-check';

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
            $response = new HtmlResponse(
                'NOT ALLOWED',
                401,
                ['reason-phrase' => 'NOT ALLOWED: ' . self::SOURCE]
            );
        }

        return $next($request, $response);
    }
}
