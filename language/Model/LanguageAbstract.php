<?php

namespace Zrcms\Language\Model;

use Zrcms\Tracking\Model\TrackableTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LanguageAbstract implements Language
{
    use TrackableTrait;

    /**
     * ***ID***
     *
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
     * @param string $name
     * @param string $iso639_2t
     * @param string $iso639_2b
     * @param string $iso639_1
     * @param string $createdByUserId
     * @param string $createdReason
     * @param string $trackingId
     */
    public function __construct(
        string $name,
        string $iso639_2t,
        string $iso639_2b,
        string $iso639_1,
        string $createdByUserId,
        string $createdReason,
        string $trackingId
    ) {
        // if has id it is immutable
        if (!empty($this->iso639_2t)) {
            return;
        }

        $this->name = $name;
        $this->iso639_2t = $iso639_2t;
        $this->iso639_2b = $iso639_2b;
        $this->iso639_1 = $iso639_1;
        $this->setCreatedData(
            $createdByUserId,
            $createdReason,
            $trackingId
        );
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
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
}
