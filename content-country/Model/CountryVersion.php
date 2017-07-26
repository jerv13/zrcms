<?php

namespace Zrcms\ContentCountry\Model;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CountryVersion extends ContentVersion
{
    /**
     * @return string
     */
    public function getIso3(): string;

    /**
     * @return string
     */
    public function getIso2(): string;

    /**
     * @return mixed
     */
    public function getName(): string;
}
