<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api\Component;

use Zrcms\ContentCore\Theme\Model\ThemeComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Component\FindComponentsByAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindThemeComponentsBy
    extends FindComponentsByAbstract
    implements \Zrcms\ContentCore\Theme\Api\Component\FindThemeComponentsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return ThemeComponent[]
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
