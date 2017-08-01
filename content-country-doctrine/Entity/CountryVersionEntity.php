<?php

namespace Zrcms\ContentCountryDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Model\PropertiesContent;
use Zrcms\ContentCountry\Model\CountryVersion;
use Zrcms\ContentCountry\Model\CountryVersionAbstract;
use Zrcms\ContentCountry\Model\PropertiesCountryVersion;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\ContentDoctrine\Entity\ContentEntityTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_country_version",
 *     indexes={}
 * )
 */
class CountryVersionEntity
    extends CountryVersionAbstract
    implements CountryVersion, ContentEntity
{
    use ContentEntityTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     *
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $properties = [];

    /**
     * Date object was first created
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdDate;

    /**
     * User ID of creator
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $createdByUserId;

    /**
     * Short description of create reason
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $createdReason;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=3)
     */
    protected $iso3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2)
     */
    protected $iso2;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
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
        $this->id = Param::getInt(
            $properties,
            PropertiesCountryVersion::ID
        );

        $this->iso3 = Param::getInt(
            $properties,
            PropertiesCountryVersion::ISO3
        );

        $this->iso2 = Param::getInt(
            $properties,
            PropertiesCountryVersion::ISO2
        );

        $this->name = Param::getInt(
            $properties,
            PropertiesCountryVersion::NAME
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
}
