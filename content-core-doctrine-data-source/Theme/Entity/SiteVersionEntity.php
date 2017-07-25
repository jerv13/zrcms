<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\ContentCore\Theme\Model\LayoutVersion;
use Zrcms\ContentCore\Theme\Model\LayoutVersionAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_layout_version",
 *     indexes={}
 * )
 */
class LayoutVersionEntity
    extends LayoutVersionAbstract
    implements LayoutVersion
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
     * @ORM\Column(type="text")
     */
    protected $html;

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
