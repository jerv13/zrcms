<?php

namespace Zrcms\ContentLanguage\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PropertiesLanguageVersion extends PropertiesContent
{
    const ISO639_2T = 'iso639_2t';
    const ISO639_2B = 'iso639_2b';
    const ISO639_1 = 'iso639_1';
    const NAME = 'name';
}
