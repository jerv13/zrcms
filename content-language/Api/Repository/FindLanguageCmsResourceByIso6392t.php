<?php

namespace Zrcms\ContentLanguage\Api\Repository;

use Zrcms\Content\Api\Repository\FindCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentLanguage\Model\LanguageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLanguageCmsResourceByIso6392t extends FindCmsResource
{
    /**
     * @param string $iso639_2t
     * @param array  $options
     *
     * @return LanguageCmsResource|CmsResource|null
     */
    public function __invoke(
        string $iso639_2t,
        array $options = []
    );
}
