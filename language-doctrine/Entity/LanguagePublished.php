<?php

namespace Zrcms\LanguageDoctrine\Language\Entity;

use Zrcms\Language\Model\LanguageAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_language_published",
 * )
 */
class LanguagePublished extends LanguageAbstract implements \Zrcms\Language\Model\LanguagePublished
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", length=3)
     */
    protected $iso639_2t;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=3)
     */
    protected $iso639_2b;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2)
     */
    protected $iso639_1;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

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
