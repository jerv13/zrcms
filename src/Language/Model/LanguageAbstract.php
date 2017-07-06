<?php

namespace Rcms\Core\Language\Model;

use Rcms\Core\Tracking\Model\TrackingTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LanguageAbstract
{
    use TrackingTrait;

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
    protected $iso639_2t = 'eng';

    /**
     * @var string Three digit ISO "bibliographic" language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes ISO Standard
     */
    protected $iso639_2b = 'eng';

    /**
     * @var string Two digit language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes ISO Standard
     */
    protected $iso639_1 = 'en';

    /**
     * @param string $name
     * @param string $iso3
     * @param string $iso2
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $name,
        string $iso639_2t,
        string $iso2,
        string $createdByUserId,
        string $createdReason
    ) {
        // if has id it is immutable
        if (!empty($this->iso3)) {
            return;
        }

        $this->name = $name;
        $this->iso639_2t = $iso639_2t;
        $this->iso2 = $iso2;
        $this->setCreatedByUserId($createdByUserId, $createdReason);
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
