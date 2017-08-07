<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewLayoutTags\Api\Repository;

use Zrcms\ContentCore\ViewLayoutTags\Model\ViewLayoutTagsGetterComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Repository\FindComponentsByAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindViewLayoutTagsGetterComponentsBy
    extends FindComponentsByAbstract
    implements \Zrcms\ContentCore\ViewLayoutTags\Api\Repository\FindViewLayoutTagsGetterComponentsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return ViewLayoutTagsGetterComponent[]
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
