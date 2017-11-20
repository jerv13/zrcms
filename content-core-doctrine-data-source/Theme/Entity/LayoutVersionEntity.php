<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\ContentCore\Theme\Fields\FieldsLayoutVersion;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\ContentDoctrine\Entity\ContentEntityAbstract;

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
    extends ContentEntityAbstract
    implements ContentEntity
{
    /**
     * @var int
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
     * Date object was first created mapped to col createdDate
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="createdDate")
     */
    protected $createdDateObject;

    /**
     * @param null|string $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        parent::__construct(
            $id,
            $properties,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }

    /**
     * @return string
     */
    public function getThemeName(): string
    {
        return $this->getProperty(
            FieldsLayoutVersion::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getProperty(
            FieldsLayoutVersion::NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return (string)$this->getProperty(
            FieldsLayoutVersion::HTML,
            ''
        );
    }
}
