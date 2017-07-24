<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api;

use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\Theme\Model\ThemeComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Api\Repository\FindComponentAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindThemeComponent
    extends FindComponentAbstract
    implements \Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent
{
    /**
     * @param string $name
     * @param array  $options
     *
     * @return ThemeComponent|Component|null
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
