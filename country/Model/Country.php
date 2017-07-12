<?php

namespace Zrcms\Country\Model;

use Zrcms\ContentVersionControl\Model\Content;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Country extends Content
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
