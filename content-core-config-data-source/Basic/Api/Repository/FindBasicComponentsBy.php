<?php

namespace Zrcms\ContentCoreConfigDataSource\Basic\Api;

use Zrcms\ContentCore\Basic\Model\BasicComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Repository\FindComponentsByAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindBasicComponentsBy
    extends FindComponentsByAbstract
    implements \Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponentsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return BasicComponent[]
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
