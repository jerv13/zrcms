<?php

namespace Zrcms\ContentLanguage\Api\Repository;

use Zrcms\Content\Api\Repository\FindCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentLanguage\Model\LanguageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLanguageCmsResourceByIso3 extends FindCmsResource
{
    /**
     * @param string $iso3
     * @param array  $options
     *
     * @return LanguageCmsResource|CmsResource|null
     */
    public function __invoke(
        string $iso3,
        array $options = []
    );
}
