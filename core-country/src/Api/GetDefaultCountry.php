<?php

namespace Zrcms\CoreCountry\Api;

use Zrcms\CoreCountry\Model\Country;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetDefaultCountry
{
    /**
     * @return Country
     * @throws \Exception
     */
    public function __invoke(): Country;
}
