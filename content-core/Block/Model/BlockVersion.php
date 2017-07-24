<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockVersion extends Block, ContentVersion
{
    /**
     * @return string|null
     */
    public function getContainerCmsResourceId(): string;

}
