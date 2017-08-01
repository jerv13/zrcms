<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\ContentCore\Page\Model\PageContainerVersion;
use Zrcms\ContentCore\Page\Model\PageContainerVersionAbstract;
use Zrcms\ContentCore\Page\Model\PropertiesPageContainerVersion;
use Zrcms\ContentCoreDoctrineDataSource\Container\Entity\ContainerBlockVersionsTrait;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\ContentDoctrine\Entity\ContentEntityTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_page_container_version",
 *     indexes={}
 * )
 */
class PageContainerVersionEntity
    extends PageContainerVersionAbstract
    implements PageContainerVersion, ContentEntity
{
    use ContainerBlockVersionsTrait;
    use ContentEntityTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
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
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $keywords;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $blockVersionsData = [];

    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->id = Param::getInt(
            $properties,
            PropertiesPageContainerVersion::ID
        );

        $this->title = Param::getString(
            $properties,
            PropertiesPageContainerVersion::TITLE
        );

        $this->keywords = Param::getString(
            $properties,
            PropertiesPageContainerVersion::KEYWORDS
        );

        $blockVersions = Param::getArray(
            $properties,
            PropertiesPageContainerVersionEntity::BLOCK_VERSIONS_DATA,
            []
        );

        $this->addBlockVersions($blockVersions);

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
}
