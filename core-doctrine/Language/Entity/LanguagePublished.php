<?php

namespace Zrcms\CoreDoctrine\Language\Entity;

use Zrcms\Core\Language\Model\LanguageAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LanguagePublished extends LanguageAbstract implements \Zrcms\Core\Language\Model\LanguagePublished
{
    /**
     * @var string
     */
    protected $name;

    /**
     * *Preferred*
     *
     * @var string Three digit ISO "terminological" language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes ISO Standard
     */
    protected $iso639_2t;

    /**
     * @var string Three digit ISO "bibliographic" language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes ISO Standard
     */
    protected $iso639_2b;

    /**
     * @var string Two digit language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes ISO Standard
     */
    protected $iso639_1;

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
