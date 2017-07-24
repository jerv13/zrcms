<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api\Repository;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\View\Model\ViewComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Repository\FindComponentAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindViewComponent
    extends FindComponentAbstract
    implements \Zrcms\ContentCore\View\Api\Repository\FindViewComponent
{
    /**
     * @param string $name
     * @param array  $options
     *
     * @return ViewComponent|Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    ) {
        return parent::__invoke(
            $name,
            $options
        );
    }
}
