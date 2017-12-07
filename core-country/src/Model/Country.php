<?php

namespace Zrcms\CoreCountry\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class Country
{
    /**
     * @var string
     */
    protected $iso3;
    /**
     * @var string
     */
    protected $iso2;
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $iso3
     * @param string $iso2
     * @param string $name
     */
    public function __construct(
        string $iso3,
        string $iso2,
        string $name
    ) {
        $this->iso3 = $iso3;
        $this->iso2 = $iso2;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getIso3(): string
    {
        return $this->iso3;
    }

    /**
     * @return string
     */
    public function getIso2(): string
    {
        return $this->iso2;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
