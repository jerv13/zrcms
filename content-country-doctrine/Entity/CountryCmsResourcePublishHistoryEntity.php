<?php

namespace Zrcms\ContentCountryDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Model\PropertiesCmsResourcePublishHistory;
use Zrcms\ContentCountry\Model\CountryCmsResourcePublishHistory;
use Zrcms\ContentCountry\Model\CountryCmsResourcePublishHistoryAbstract;
use Zrcms\ContentDoctrine\Entity\CmsResourcePublishHistoryEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourcePublishHistoryEntityTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_country_resource_publish_history",
 *     indexes={}
 * )
 */
class CountryCmsResourcePublishHistoryEntity
    extends CountryCmsResourcePublishHistoryAbstract
    implements CountryCmsResourcePublishHistory, CmsResourcePublishHistoryEntity
{
    use CmsResourcePublishHistoryEntityTrait;

    /**
     * @var int
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
    protected $contentVersionId = null;

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
    protected $action;

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
        // Force Id to int
        $properties[PropertiesCmsResourcePublishHistory::ID] = Param::getInt(
            $properties,
            PropertiesCmsResourcePublishHistory::ID
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
}
