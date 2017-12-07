<?php

namespace Zrcms\CoreTheme\Api\Content;

use Zrcms\Core\Api\Content\InsertContentVersion;
use Zrcms\Core\Model\ContentVersion;
use Zrcms\CoreTheme\Model\LayoutVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertLayoutVersion extends InsertContentVersion
{
    /**
     * @param LayoutVersion|ContentVersion $layoutVersion
     * @param array                        $options
     *
     * @return LayoutVersion|ContentVersion
     */
    public function __invoke(
        ContentVersion $layoutVersion,
        array $options = []
    ): ContentVersion;
}
