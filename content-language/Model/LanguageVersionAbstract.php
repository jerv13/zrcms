<?php

namespace Zrcms\ContentLanguage\Model;

use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LanguageVersionAbstract extends ContentVersionAbstract implements LanguageVersion
{
    /**
     * Three digit ISO 639-2/T "terminological" language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes
     *
     * @var string
     */
    protected $iso639_2t;

    /**
     * Three digit ISO 639-2/B "bibliographic" language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes
     *
     * @var string
     */
    protected $iso639_2b;

    /**
     * Two digit iso639_1 language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes
     *
     * @var string
     */
    protected $iso639_1;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->iso639_2t = Param::getRequired(
            $properties,
            PropertiesLanguageVersion::ISO639_2T
        );

        $this->iso639_2b = Param::getRequired(
            $properties,
            PropertiesLanguageVersion::ISO639_2B
        );

        $this->iso639_1 = Param::getRequired(
            $properties,
            PropertiesLanguageVersion::ISO639_1
        );

        $this->name = Param::getRequired(
            $properties,
            PropertiesLanguageVersion::NAME
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getIso6392t(): string
    {
        return $this->iso639_2t;
    }

    /**
     * @return string
     */
    public function getIso6392b(): string
    {
        return $this->iso639_2b;
    }

    /**
     * @return string
     */
    public function getIso6391(): string
    {
        return $this->iso639_1;
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }
}
