<?php

namespace Zrcms\ContentLanguage\Model;

use Zrcms\Tracking\Model\TrackableTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LanguageAbstract implements Language
{
    use TrackableTrait;

    /**
     * @var string
     */
    protected $uid;

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
     * @param string $uid
     * @param string $name
     * @param string $iso639_2t
     * @param string $iso639_2b
     * @param string $iso639_1
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $uid,
        string $iso639_2t,
        string $iso639_2b,
        string $iso639_1,
        string $name,
        string $createdByUserId,
        string $createdReason
    ) {
        // if has id it is immutable
        if (!empty($this->uid)) {
            return;
        }

        $this->iso639_2t = $iso639_2t;
        $this->iso639_2b = $iso639_2b;
        $this->iso639_1 = $iso639_1;
        $this->name = $name;
        $this->setCreatedData(
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getUid(): string
    {
        return $this->uid;
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
