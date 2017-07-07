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
     * ***Preferred Code***
     *
     * Three digit iso639_2t "terminological" language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes
     *
     * @return string
     */
    public function getIso6392t(): string;

    /**
     * Three digit iso639_2b "bibliographic" language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes
     *
     * @return string
     */
    public function getIso6392b(): string;

    /**
     * Two digit iso639_1 language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes
     *
     * @return string
     */
    public function getIso6391(): string;
}