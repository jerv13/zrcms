<?php

namespace Rcms\Core\Language\Model;

use Rcms\Core\Tracking\Model\Tracking;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Language extends Tracking
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
