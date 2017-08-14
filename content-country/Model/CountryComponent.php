<?php

namespace Zrcms\ContentCountry\Model;

use Zrcms\Content\Model\Component;

interface CountryComponent extends Component
{
    /**
     * Default config values
     *
     * @return array
     */
    public function getCountry($iso3): array;

    /**
     * @return bool
     */
    public function getAll(): bool;
}
