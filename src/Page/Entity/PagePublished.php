<?php

namespace Rcms\Core\Page\Entity;

use Doctrine\ORM\Mapping as ORM;
use Rcms\Core\Page\Model\PageAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="rcms_core_page_published",
 *     indexes={
 *         @ORM\Index(name="url_index", columns={"url"})
 *     }
 * )
 */
class PagePublished extends PageAbstract implements \Rcms\Core\Page\Model\PagePublished
{
    /**
     * @var string
     *
     * @ORM\Id
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
}
