<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Entity;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Zrcms\ContentCore\Page\Fields\FieldsPageContainerVersion;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\ContentDoctrine\Entity\ContentEntityAbstract;
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
    extends ContentEntityAbstract
    implements ContentEntity
{
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
     * Date object was first created mapped to col createdDate
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="createdDate")
     */
    protected $createdDateObject;

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
    protected $blockVersions = [];

    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->title = Param::getString(
            $properties,
            FieldsPageContainerVersion::TITLE
        );

        $this->keywords = Param::getString(
            $properties,
            FieldsPageContainerVersion::KEYWORDS
        );

        $this->blockVersions = Param::getArray(
            $properties,
            FieldsPageContainerVersion::BLOCK_VERSIONS,
            []
        );

        Param::remove($properties, FieldsPageContainerVersion::BLOCK_VERSIONS);

        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        $properties = parent::getProperties();
        $properties[FieldsPageContainerVersion::BLOCK_VERSIONS] = $this->getBlockVersions();

        return $properties;
    }

    /**
     * @return array
     */
    public function getBlockVersions(): array
    {
        return $this->blockVersions;
    }

    /**
     * @return void
     *
     * @ORM\PostPersist
     */
    public function postPersist(LifecycleEventArgs $event)
    {
        $this->properties[FieldsPageContainerVersion::TITLE] = $this->title;
        $this->properties[FieldsPageContainerVersion::KEYWORDS] = $this->keywords;
    }
}
