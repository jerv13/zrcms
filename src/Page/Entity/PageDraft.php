<?php

namespace Rcms\Core\Page\Entity;

use Doctrine\ORM\Mapping as ORM;
use Rcms\Core\Page\Model\PageAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="rcms_core_page_draft",
 *     indexes={
 *         @ORM\Index(name="url_index", columns={"url"})
 *     }
 * )
 */
class PageDraft extends PageAbstract implements \Rcms\Core\Page\Model\PageDraft
{
    /**
     * @var int Auto-Incremented Primary Key
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $url;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $properties = [];

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $blockInstances = [];

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
