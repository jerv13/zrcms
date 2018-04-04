<?php

namespace Zrcms\Core\Api\Content;

use Zrcms\Core\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ContentVersionToArray
{
    const OPTION_HIDE_PROPERTIES = 'hideProperties';
    const OPTION_PROPERTIES_OPTIONS = 'propertiesOptions';

    /**
     * @param ContentVersion $contentVersion
     * @param array          $options
     *
     * @return array
     */
    public function __invoke(
        ContentVersion $contentVersion,
        array $options = []
    ): array;
}
