<?php

namespace Zrcms\CoreDoctrine\Page\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Core\Page\Model\PageAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_page_template",
 *     indexes={
 *         @ORM\Index(name="uid_index", columns={"uid"})
 *     }
 * )
 */
class PageTemplate extends PageAbstract implements \Zrcms\Core\Page\Model\PageTemplate
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
     * @ORM\Column(type="string")
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
     * @return void
     *
     * @ORM\PrePersist
     */
    public function assertHasTrackingData()
    {
        parent::assertHasTrackingData();
    }
}
