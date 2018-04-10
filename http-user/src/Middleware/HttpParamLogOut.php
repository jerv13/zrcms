<?php

namespace Zrcms\HttpUser\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zend\Diactoros\Response\RedirectResponse;
use Zrcms\User\Api\LogOut;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpParamLogOut implements MiddlewareInterface
{
    const PARAM_LOGOUT = 'logout';

    /**
     * @var LogOut
     */
    protected $logout;

    /**
     * @var int
     */
    protected $redirectStatus = 302;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @param LogOut $logout
     * @param int    $redirectStatus
     * @param array  $headers
     */
    public function __construct(
        LogOut $logout,
        int $redirectStatus = 302,
        array $headers = []
    ) {
        $this->logout = $logout;
        $this->redirectStatus = $redirectStatus;
        $this->headers = $headers;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface|RedirectResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        $params = $request->getQueryParams();

        $doLogout = Property::getBool(
            $params,
            self::PARAM_LOGOUT,
            false
        );

        if ($doLogout) {
            $this->logout->__invoke(
                $request
            );

            // @todo Preserve other query strings

            return new RedirectResponse(
                $request->getUri()->getPath(),
                $this->redirectStatus,
                $this->headers
            );
        }

        return $delegate->process($request);
    }
}
