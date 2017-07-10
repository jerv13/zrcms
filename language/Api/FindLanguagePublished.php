<?php

namespace Zrcms\Language\Api;

use Zrcms\Language\Model\LanguagePublished;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLanguagePublished
{
    /**
     * @param string $iso639_2t
     * @param array  $options
     *
     * @return LanguagePublished|null
     */
    public function __invoke(
        string $iso639_2t,
        array $options = []
    );
}
