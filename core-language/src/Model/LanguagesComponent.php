<?php
// phpcs:ignoreFile @todo Method names is not in camel caps format (no underscores allowed)
namespace Zrcms\CoreLanguage\Model;

use Zrcms\Core\Model\Component;
use Zrcms\Core\Model\ComponentAbstract;

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
            $languages[$iso639_2t] = $this->findLanguage($iso639_2t, null);
        }

        return $languages;
    }

    /**
     * @return array
     */
    public function getLanguagesArray(): array
    {
        return $this->properties['languages'];
    }

    /**
     * @param string $iso639_2t
     * @param null   $default
     *
     * @return Language|null
     */
    public function findLanguage(string $iso639_2t, $default = null)
    {
        $languageArray = $this->findLanguageArray($iso639_2t, null);

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
    public function findLanguageArray(string $iso639_2t, $default = null)
    {
        if (array_key_exists($iso639_2t, $this->properties['languages'])) {
            return $this->properties['languages'][$iso639_2t];
        }

        return $default;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return array
     */
    public function filterLanguageArray($key, $value)
    {
        $result = array_filter(
            $this->properties['languages'],
            function ($LanguageArray) use ($key, $value) {
                if (array_key_exists($key, $LanguageArray) && $LanguageArray[$key] == $value) {
                    return true;
                }

                return false;
            }
        );

        return $result;
    }

    /**
     * @param string $iso639_2b
     * @param null   $default
     *
     * @return null|Language
     */
    public function findLanguageByIso639_2b(string $iso639_2b, $default = null)
    {
        $languageArray = $this->findLanguageArrayByIso639_2b($iso639_2b, null);

        if (empty($languageArray)) {
            return $default;
        }

        return $this->buildLanguage($languageArray);
    }

    /**
     * @param string $iso639_2b
     * @param null   $default
     *
     * @return array
     */
    public function findLanguageArrayByIso639_2b(string $iso639_2b, $default = null)
    {
        $result = $this->filterLanguageArray('iso639_2b', $iso639_2b);

        if (count($result) > 0) {
            return $result[0];
        }

        return $default;
    }

    /**
     * @param string $iso639_1
     * @param null   $default
     *
     * @return null|Language
     */
    public function findLanguageByIso639_1(string $iso639_1, $default = null)
    {
        $languageArray = $this->findLanguageArrayByIso639_1($iso639_1, null);

        if (empty($languageArray)) {
            return $default;
        }

        return $this->buildLanguage($languageArray);
    }

    /**
     * @param string $iso639_1
     * @param null   $default
     *
     * @return array
     */
    public function findLanguageArrayByIso639_1(string $iso639_1, $default = null)
    {
        $result = $this->filterLanguageArray('iso639_1', $iso639_1);

        if (count($result) > 0) {
            return $result[0];
        }

        return $default;
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return null|Language
     */
    public function findLanguageByName(string $name, $default = null)
    {
        $languageArray = $this->findLanguageArrayByName($name, null);

        if (empty($languageArray)) {
            return $default;
        }

        return $this->buildLanguage($languageArray);
    }

    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed|null
     */
    public function findLanguageArrayByName(string $name, $default = null)
    {
        $result = $this->filterLanguageArray('name', $name);

        if (count($result) > 0) {
            return $result[0];
        }

        return $default;
    }

    /**
     * @param array $languageArray
     *
     * @return Language
     */
    public function buildLanguage(array $languageArray)
    {
        return new Language(
            $languageArray['iso639_2t'],
            $languageArray['iso639_2b'],
            $languageArray['iso639_1'],
            $languageArray['name']
        );
    }
}
