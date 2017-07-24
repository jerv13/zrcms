<?php

namespace Zrcms\CoreConfigDataSource\View\Api\Repository;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCore\View\Api\Render\GetViewRenderData;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindViewRenderDataGetters implements \Zrcms\ContentCore\View\Api\Repository\FindViewRenderDataGetters
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var array
     */
    protected $registryConfig;

    /**
     * @param ContainerInterface $serviceContainer
     * @param array              $registryConfig
     */
    public function __construct(
        $serviceContainer,
        array $registryConfig
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->registryConfig = $registryConfig;
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [serviceNames]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        $viewRenderDataGetters = [];

        foreach ($this->registryConfig as $viewRenderDataGetterServiceName) {
            /** @var GetViewRenderData $getViewRenderDataService */
            $viewRenderDataGetters[] = $this->serviceContainer->get(
                $viewRenderDataGetterServiceName
            );
        }

        return $viewRenderDataGetters;
    }
}
