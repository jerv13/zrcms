<?php

namespace Zrcms\ContentLanguage\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class Language
{
    /**
     * @var string
     */
    protected $iso639_2t;
    /**
     * @var string
     */
    protected $iso639_2b;
    /**
     * @var string
     */
    protected $iso639_1;
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $iso639_2t
     * @param string $iso639_2b
     * @param string $iso639_1
     * @param string $name
     */
    public function __construct(
        string $iso639_2t,
        string $iso639_2b,
        string $iso639_1,
        string $name
    ) {
        $this->iso639_2t = $iso639_2t;
        $this->iso639_2b = $iso639_2b;
        $this->iso639_1 = $iso639_1;
        $this->name = $name;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
