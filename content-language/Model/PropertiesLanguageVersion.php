<?php

namespace Zrcms\ContentLanguage\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesLanguageVersion extends PropertiesContent
{
    const ISO_639_2T = 'iso639_2t';
    const ISO_639_2B = 'iso639_2b';
    const ISO_639_1 = 'iso639_1';
    const NAME = 'name';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::ISO_639_2T => '',
            self::ISO_639_2B => '',
            self::ISO_639_1 => '',
            self::NAME => '',
        ];
}
