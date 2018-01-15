<?php

namespace Zrcms\Core\Api\Content;

use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ContentVersionsToArray
{
    const OPTION_CONTENT_OPTIONS = 'content-options';
    const OPTION_HIDE_PROPERTIES = 'hideProperties';

    /**
     * @param ContentVersion[] $contentVersion
     * @param array            $options
     *
     * @return array
     */
    public function __invoke(
        array $contentVersion,
        array $options = []
    ): array;
}
