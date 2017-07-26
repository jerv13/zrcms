<?php

namespace Zrcms\ContentCountryDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\ContentCountry\Model\CountryVersion;
use Zrcms\ContentCountry\Model\CountryVersionAbstract;

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
    implements CountryVersion
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
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
     * @ORM\Id
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
     * @return void
     *
     * @ORM\PrePersist
     */
    public function assertHasTrackingData()
    {
        parent::assertHasTrackingData();
    }
}
