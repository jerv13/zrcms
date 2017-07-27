<?php

namespace Zrcms\ContentCountry\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CountryVersionAbstract extends ContentVersionAbstract implements CountryVersion
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
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->iso3 = Param::getRequired(
            $properties,
            PropertiesCountryVersion::ISO3,
            new PropertyMissingException(
                'Required property (' . PropertiesCountryVersion::ISO3. ') is missing in: '
                . get_class($this)
            )
        );

        $this->iso2 = Param::getRequired(
            $properties,
            PropertiesCountryVersion::ISO2,
            new PropertyMissingException(
                'Required property (' . PropertiesCountryVersion::ISO2. ') is missing in: '
                . get_class($this)
            )
        );

        $this->name = Param::getRequired(
            $properties,
            PropertiesCountryVersion::NAME,
            new PropertyMissingException(
                'Required property (' . PropertiesCountryVersion::NAME. ') is missing in: '
                . get_class($this)
            )
        );

        parent::__construct(
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
