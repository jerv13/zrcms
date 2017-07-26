<?php

namespace Zrcms\ContentLanguage\Model;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface LanguageVersion extends ContentVersion
{
    /**
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

    /**
     * @return mixed
     */
    public function getName(): string;
}
