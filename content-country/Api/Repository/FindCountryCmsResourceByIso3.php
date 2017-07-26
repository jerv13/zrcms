<?php

namespace Zrcms\ContentCountry\Api\Repository;

use Zrcms\Content\Api\Repository\FindCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCountry\Model\CountryCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindCountryCmsResourceByIso3 extends FindCmsResource
{
    /**
     * @param string $iso3
     * @param array  $options
     *
     * @return CountryCmsResource|CmsResource|null
     */
    public function __invoke(
        string $iso3,
        array $options = []
    );
}
