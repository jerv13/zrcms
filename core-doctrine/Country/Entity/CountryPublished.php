<?php

namespace Zrcms\CoreDoctrine\Country\Entity;

use Zrcms\Core\Country\Model\CountryAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class CountryPublished extends CountryAbstract implements \Zrcms\Core\Country\Model\CountryPublished
{
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
     * Globally unique tracking ID
     *
     * Tracking id for tracking changes to content when data is build from existing source
     * For example, if you are building a new  object
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $trackingId;
}
