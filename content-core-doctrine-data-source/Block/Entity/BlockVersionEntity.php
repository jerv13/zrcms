<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Block\Entity;

use Zrcms\ContentCore\Block\Model\BlockVersion;
use Zrcms\ContentCore\Block\Model\BlockVersionAbstract;

use Doctrine\ORM\Mapping as ORM;

/**
 * NOT USED
 *
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_block_version",
 *     indexes={
 *         @ORM\Index(name="block_component_name_index", columns={"blockComponentName"})
 *     }
 * )
 */
class BlockVersionEntity extends BlockVersionAbstract implements BlockVersion
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $properties = null;

    /**
     * Date object was first created
     *
     * @var \DateTime
     */
    protected $createdDate;

    /**
     * User ID of creator
     *
     * @var string
     */
    protected $createdByUserId;

    /**
     * Short description of create reason
     *
     * @var string
     */
    protected $createdReason;

    /////////////////////////////////////

    /**
     * @var string
     */
    protected $containerCmsResourceId;

    /**
     * @var string
     */
    protected $blockComponentName;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $layoutProperties = [];
}
