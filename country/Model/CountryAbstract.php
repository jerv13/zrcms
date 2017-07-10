<?php

namespace Zrcms\Country\Model;

use Zrcms\Tracking\Model\TrackableTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CountryAbstract implements Country
{
    use TrackableTrait;

    /**
     * @var string
     */
    protected $uid;

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
     * @param string $uid
     * @param string $iso3
     * @param string $iso2
     * @param string $name
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $uid,
        string $iso3,
        string $iso2,
        string $name,
        string $createdByUserId,
        string $createdReason
    ) {
        // if has id it is immutable
        if (!empty($this->iso3)) {
            return;
        }

        $this->uid = $uid;
        $this->iso3 = $iso3;
        $this->iso2 = $iso2;
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
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
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
}
