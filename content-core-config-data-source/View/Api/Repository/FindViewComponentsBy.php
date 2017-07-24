<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api\Repository;

use Zrcms\ContentCore\View\Model\ViewComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Repository\FindComponentsByAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindViewComponentsBy
    extends FindComponentsByAbstract
    implements \Zrcms\ContentCore\View\Api\Repository\FindViewComponentsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return ViewComponent[]
     * @throws \Exception
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        return parent::__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset,
            $options
        );
    }
}
