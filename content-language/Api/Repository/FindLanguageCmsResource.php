<?php

namespace Zrcms\ContentLanguage\Api\Repository;

use Zrcms\Content\Api\Repository\FindCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentLanguage\Model\LanguageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLanguageCmsResource extends FindCmsResource
{
    /**
     * @param string $host
     * @param array  $options
     *
     * @return LanguageCmsResource|CmsResource|null
     */
    public function __invoke(
        string $host,
        array $options = []
    );
}
