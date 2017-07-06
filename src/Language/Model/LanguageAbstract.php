<?php

namespace Rcms\Core\Language\Model;

use Rcms\Core\Tracking\Model\TrackableTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LanguageAbstract implements Language
{
    use TrackableTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * *Preferred*
     *
     * @var string Three digit ISO "terminological" language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes ISO Standard
     */
    protected $iso639_2t;

    /**
     * @var string Three digit ISO "bibliographic" language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes ISO Standard
     */
    protected $iso639_2b;

    /**
     * @var string Two digit language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes ISO Standard
     */
    protected $iso639_1;

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
