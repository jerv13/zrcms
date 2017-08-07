<?php

namespace Zrcms\ContentCore\ViewLayoutTags\Api\Repository;

use Zrcms\Content\Api\Repository\FindComponent;
use Zrcms\Content\Model\Component;
use Zrcms\ContentCore\ViewLayoutTags\Model\ViewLayoutTagsGetterComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindViewLayoutTagsGetterComponent extends FindComponent
{
    /**
     * @param string $name
     * @param array  $options
     *
     * @return ViewLayoutTagsGetterComponent|Component|null
     */
    public function __invoke(
        string $name,
        array $options = []
    );
}
