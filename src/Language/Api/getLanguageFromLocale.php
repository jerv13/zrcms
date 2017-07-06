<?php

namespace Rcms\Core\Language\Api;

use Rcms\Core\Language\Model\Language;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface getLanguageFromLocale
{
    /**
     * @param string $locale
     * @param array  $options
     *
     * @return Language|null
     */
    public function __invoke(string $locale, $options = []);
}
