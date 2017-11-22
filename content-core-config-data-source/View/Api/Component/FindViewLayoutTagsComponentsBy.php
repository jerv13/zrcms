<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api\Component;

use Zrcms\ContentCore\View\Model\ViewLayoutTagsComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Component\FindComponentsByAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindViewLayoutTagsComponentsBy
    extends FindComponentsByAbstract
    implements \Zrcms\ContentCore\View\Api\Component\FindViewLayoutTagsComponentsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return ViewLayoutTagsComponent[]
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
