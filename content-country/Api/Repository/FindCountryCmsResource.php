<?php

namespace Zrcms\ContentCountry\Api\Repository;

use Zrcms\Content\Api\Repository\FindCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCountry\Model\CountryCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindCountryCmsResource extends FindCmsResource
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return CountryCmsResource|CmsResource|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
