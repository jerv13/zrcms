<?php

namespace Zrcms\ContentLanguage\Api\Repository;

use Zrcms\Content\Api\Repository\FindContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentLanguage\Model\LanguageVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLanguageVersion extends FindContentVersion
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return LanguageVersion|ContentVersion|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
