<?php

namespace Zrcms\Core\PageView\Api\Repository;

use Psr\Container\ContainerInterface;
use Zrcms\Core\PageView\Api\Render\GetPageViewRenderData;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindPageViewRenderDataServicesBasic implements FindPageViewRenderDataServices
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @var array
     */
    protected $getPageViewRenderDataServiceNames;

    /**
     * @param ContainerInterface $serviceContainer
     * @param array              $getPageViewRenderDataServiceNames
     */
    public function __construct(
        $serviceContainer,
        array $getPageViewRenderDataServiceNames
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->getPageViewRenderDataServiceNames = $getPageViewRenderDataServiceNames;
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
        $getPageViewRenderDataServices = [];

        foreach ($this->getPageViewRenderDataServiceNames as $getPageViewRenderDataServiceName) {
            /** @var GetPageViewRenderData $getPageViewRenderDataService */
            $getPageViewRenderDataServices[] = $this->serviceContainer->get(
                $getPageViewRenderDataServiceName
            );
        }

        return $getPageViewRenderDataServices;
    }
}
