<?php

namespace Zrcms\HttpUser\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Reliv\ArrayProperties\Property;
use Zrcms\User\Api\LogOut;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpParamLogOut
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

        return $next($request, $response);
    }
}
