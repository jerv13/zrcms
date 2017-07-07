<?php

namespace Zrcms\Core\Country\Model;

use Zrcms\Core\Tracking\Model\TrackableTrait;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CountryAbstract implements Country
{
    use TrackableTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $iso3;

    /**
     * @var string
     */
    protected $iso2;

    /**
     * @param string $name
     * @param string $iso3
     * @param string $iso2
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $name,
        string $iso3,
        string $iso2,
        string $createdByUserId,
        string $createdReason,
        string $trackingId
    ) {
        // if has id it is immutable
        if (!empty($this->iso3)) {
            return;
        }

        $this->name = $name;
        $this->iso3 = $iso3;
        $this->iso2 = $iso2;
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
