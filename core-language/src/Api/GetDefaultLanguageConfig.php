<?php

namespace Zrcms\CoreLanguage\Api;

use Reliv\ArrayProperties\Property;
use Zrcms\CoreLanguage\Model\Language;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetDefaultLanguageConfig implements GetDefaultLanguage
{
    protected $defaultLanguageConfig;

    /**
     * @param array $defaultLanguageConfig
     */
    public function __construct(
        array $defaultLanguageConfig
    ) {
        $this->defaultLanguageConfig = $defaultLanguageConfig;
    }

    /**
     * @return Language
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     * @throws \Throwable
     */
    public function __invoke(): Language
    {
        return new Language(
            Property::getRequired(
                $this->defaultLanguageConfig,
                'iso639_2t'
            ),
            Property::getRequired(
                $this->defaultLanguageConfig,
                'iso639_2b'
            ),
            Property::getRequired(
                $this->defaultLanguageConfig,
                'iso639_1'
            ),
            Property::getRequired(
                $this->defaultLanguageConfig,
                'name'
            )
        );
    }
}
