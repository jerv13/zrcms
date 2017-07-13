<?php

namespace Zrcms\Core\Layout\Api\Repository;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Layout\Api\Render\GetLayoutRenderData;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindLayoutRenderDataServicesBasic implements FindLayoutRenderDataServices
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var array
     */
    protected $getLayoutRenderDataServiceNames;

    /**
     * @param ContainerInterface $serviceContainer
     * @param array              $getLayoutRenderDataServiceNames
     */
    public function __construct(
        $serviceContainer,
        array $getLayoutRenderDataServiceNames
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->getLayoutRenderDataServiceNames = $getLayoutRenderDataServiceNames;
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
        $getLayoutRenderDataServices = [];

        foreach ($this->getLayoutRenderDataServiceNames as $getLayoutRenderDataServiceName) {
            /** @var GetLayoutRenderData $getLayoutRenderDataService */
            $getLayoutRenderDataServices[] = $this->serviceContainer->get(
                $getLayoutRenderDataServiceName
            );
        }

        return $getLayoutRenderDataServices;
    }
}
