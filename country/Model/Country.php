<?php

namespace Zrcms\Country\Model;

use Zrcms\Tracking\Model\Trackable;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Country extends Trackable
{
    /**
     * @return mixed
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getIso3(): string;

    /**
     * @return string
     */
    public function getIso2(): string;
}
