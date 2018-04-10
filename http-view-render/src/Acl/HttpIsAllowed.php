<?php

namespace Zrcms\HttpViewRender\Acl;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zrcms\Acl\Api\IsAllowed;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpIsAllowed implements MiddlewareInterface
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
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|HtmlResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        if (!$this->isAllowed->__invoke($request, $this->aclOptions)) {
            return new HtmlResponse(
                'NOT ALLOWED',
                401,
                ['reason-phrase' => 'NOT ALLOWED: ' . self::SOURCE]
            );
        }

        return $delegate->process($request);
    }
}
