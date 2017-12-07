<?php

namespace Zrcms\Core\Api\Content;

use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertContentVersion
{
    /**
     * @param ContentVersion $contentVersion
     * @param array           $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $contentVersion,
        array $options = []
    ): ContentVersion;
}
