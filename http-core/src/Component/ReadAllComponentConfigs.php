<?php

namespace Zrcms\HttpCore\Component;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zrcms\Http\Response\ZrcmsJsonResponse;

/**
 * @deprecated @todo Fix ME
 * @author James Jervis - https://github.com/jerv13
 */
class ReadAllComponentConfigs
{
    const SOURCE = 'zrcms-get-register-components';

    /**
     * @var \Zrcms\Core\Api\Component\ReadAllComponentConfigs
     */
    protected $readAllComponentConfigs;

    /**
     * @param \Zrcms\Core\Api\Component\ReadAllComponentConfigs $readAllComponentConfigs
     */
    public function __construct(
        \Zrcms\Core\Api\Component\ReadAllComponentConfigs $readAllComponentConfigs
    ) {
        $this->readAllComponentConfigs = $readAllComponentConfigs; //$config['zrcms-components'];
    }

    /**
     * @param ServerRequestInterface              $request
     * @param ResponseInterface|ZrcmsJsonResponse $response
     * @param callable|null                       $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        $allComponentConfigs = $this->readAllComponentConfigs->__invoke();
        ksort($allComponentConfigs);
        return new ZrcmsJsonResponse(
            $allComponentConfigs
        );
    }
}
