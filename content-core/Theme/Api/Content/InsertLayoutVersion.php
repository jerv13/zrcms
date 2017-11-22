<?php

namespace Zrcms\ContentCore\Theme\Api\Content;

use Zrcms\Content\Api\Content\InsertContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentCore\Theme\Model\LayoutVersion;

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
