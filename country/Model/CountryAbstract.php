<?php

namespace Zrcms\Country\Model;

use Zrcms\ContentVersionControl\Model\ContentAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CountryAbstract extends ContentAbstract implements Country
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
     * @param string $id
     * @param string $sourceUri
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     * @param string $iso3
     * @param string $iso2
     * @param string $name
     */
    public function __construct(
        string $id,
        string $sourceUri,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        string $iso3,
        string $iso2,
        string $name
    ) {
        $this->iso3 = $iso3;
        $this->iso2 = $iso2;
        $this->name = $name;

        parent::__construct(
            $id,
            $sourceUri,
            $properties,
            $createdByUserId,
            $createdReason
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
