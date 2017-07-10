<?php

namespace Zrcms\CoreDoctrine\Page\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_page_deleted",
 *     indexes={
 *         @ORM\Index(name="uri_index", columns={"uri"}),
 *         @ORM\Index(name="uid_index", columns={"uid"})
 *     }
 * )
 */
class PageDeleted extends PageAbstract implements \Zrcms\Core\Page\Model\PageDeleted
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    protected $uid;

    /**
     * <identifier>
     *
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string", nullable=false)
     */
    protected $uri;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

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
