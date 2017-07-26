<?php

namespace Zrcms\ContentLanguage\Api\Repository;

use Zrcms\Content\Api\Repository\InsertContentVersion;
use Zrcms\Content\Model\ContentVersion;
use Zrcms\ContentLanguage\Model\LanguageVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface InsertLanguageVersion extends InsertContentVersion
{
    /**
     * @param LanguageVersion|ContentVersion $languageVersion
     * @param array                      $options
     *
     * @return ContentVersion
     */
    public function __invoke(
        ContentVersion $languageVersion,
        array $options = []
    ): ContentVersion;
}
