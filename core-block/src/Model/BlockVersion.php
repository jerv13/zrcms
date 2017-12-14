<?php

namespace Zrcms\CoreBlock\Model;

use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockVersion extends Block, ContentVersion
{
    /**
     * @return string|null
     */
    public function getContainerVersionId(): string;
}
