<?php

namespace Zrcms\ContentCountry\Model;

use Zrcms\Content\Model\ComponentAbstract;

class CountryComponentBasic extends ComponentAbstract implements CountryComponent
{

    public function getAll(): bool
    {
        return $this->properties['countries'];
    }

    public function getCountry($iso3): array
    {
        return $this->properties['countries'][$iso3];
    }
}
