<?php

namespace Zrcms\Locale\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface SetLocale
{
    /**
     * @param       $locale
     * @param array $options
     *
     * @return string
     */
    public function __invoke(
        $locale,
        array $options = []
    ): string;
}
