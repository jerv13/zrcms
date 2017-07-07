<?php

namespace Zrcms\Language\Model;

use Zrcms\Tracking\Model\Trackable;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Language extends Trackable
{
    /**
     * @return mixed
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getIso6392t(): string;

    /**
     * @return string
     */
    public function getIso6392b(): string;

    /**
     * @return string
     */
    public function getIso6391(): string;
}
