<?php

namespace Zrcms\CoreView\Api;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\ArrayProperties\Property;
use Zrcms\CoreView\Exception\InvalidGetViewByRequest;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetViewByRequestComposite implements GetViewByRequest
{
    const KEY_API = 'api';
    const KEY_PRIORITY = 'priority';

    protected $getViewByRequestApiList;
    protected $serviceContainer;
    protected $defaultStrategyName;

    /**
     * @param array              $config
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(
        array $config,
        ContainerInterface $serviceContainer
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->setGetViewByRequestApiList($config);
    }

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws InvalidGetViewByRequest
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): View {
        foreach ($this->getViewByRequestApiList as $name => $getViewByRequestServiceName) {
            /** @var GetViewByRequest $getViewByRequest */
            $getViewByRequest = $this->serviceContainer->get($getViewByRequestServiceName);

            if (!is_a($getViewByRequest, GetViewByRequest::class)) {
                throw new \Exception(
                    'GetViewByRequest API '
                    . ' must be instance of: (' . GetViewByRequest::class . ')'
                    . ' for service: (' . $getViewByRequestServiceName . ')'
                );
            }
            try {
                $view = $getViewByRequest->__invoke(
                    $request,
                    $options
                );
            } catch (InvalidGetViewByRequest $exception) {
                // try the next one
                continue;
            }

            return $view->withProperty(self::VIEW_PROPERTY_GET_VIEW_API_NAME, $name);
        }

        throw new InvalidGetViewByRequest(
            'No valid GetViewByRequest API found in: ' . static::class
        );
    }

    /**
     * @param array $config
     *
     * @return void
     */
    protected function setGetViewByRequestApiList(array $config)
    {
        $queue = new \SplPriorityQueue();

        foreach ($config as $name => $apiConfig) {
            $queue->insert(
                $name,
                Property::getInt(
                    $apiConfig,
                    static::KEY_PRIORITY,
                    0
                )
            );
        }

        foreach ($queue as $name) {
            $this->getViewByRequestApiList[$name] = $config[$name][static::KEY_API];
        }
    }
}
