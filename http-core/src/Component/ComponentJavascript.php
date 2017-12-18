<?php

namespace Zrcms\HttpCore\Component;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ComponentJavascript
{
    const SCHEME = 'component';

    protected $readFile;
    protected $defaultDebug;

    /**
     * @param ReadFile $readFile
     * @param bool     $defaultDebug
     */
    public function __construct(
        ReadFile $readFile,
        bool $defaultDebug = true
    ) {
        $this->readFile = $readFile;
        $this->defaultDebug = $defaultDebug;
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

    }
}
