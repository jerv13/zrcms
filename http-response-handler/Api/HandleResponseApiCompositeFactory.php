<?php

namespace Zrcms\HttpResponseHandler\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HandleResponseApiCompositeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HandleResponseComposite
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $handlersConfig = $config['zrcms-response-handlers-api'];

        $queue = new \SplPriorityQueue();

        foreach ($handlersConfig as $handlerConfig) {
            $handler = $serviceContainer->get($handlerConfig['response-handler']);
            $priority = (array_key_exists('priority', $handlerConfig) ? $handlerConfig['priority'] : 0);
            $queue->insert($handler, $priority);
        }

        return new HandleResponseComposite(
            $queue
        );
    }
}
