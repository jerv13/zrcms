<?php

namespace Zrcms\ContentLanguage\Model;

use Zrcms\Content\Model\Component;
use Zrcms\Content\Model\ComponentAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LanguagesComponent extends ComponentAbstract implements Component
{
    /**
     * @return Language[]
     */
    public function getLanguages(): array
    {
        $languages = [];
        foreach ($this->properties['languages'] as $iso639_2t => $value) {
            $languages[$iso639_2t] = $this->getLanguage($iso639_2t, null);
        }

        return $languages;
    }

    /**
     * @param string $iso639_2t
     * @param null   $default
     *
     * @return array
     */
    public function getLanguagesArray(string $iso639_2t, $default = null): array
    {
        return $this->properties['languages'];
    }

    /**
     * @param string $iso639_2t
     * @param null   $default
     *
     * @return Language|null
     */
    public function getLanguage(string $iso639_2t, $default = null)
    {
        $languageArray = $this->getLanguageArray($iso639_2t, null);

        if (empty($languageArray)) {
            return $default;
        }

        return new Language(
            $languageArray['iso639_2t'],
            $languageArray['iso639_2b'],
            $languageArray['iso639_1'],
            $languageArray['name']
        );
    }

    /**
     * @param string $iso639_2t
     * @param null   $default
     *
     * @return array
     */
    public function getLanguageArray(string $iso639_2t, $default = null)
    {
        if (array_key_exists($iso639_2t, $this->properties['languages'])) {
            return $this->properties['languages'][$iso639_2t];
        }

        return $default;
    }
}
