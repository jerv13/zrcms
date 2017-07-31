<?php

namespace Zrcms\ContentLanguageDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Model\PropertiesContent;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\ContentDoctrine\Entity\ContentEntityTrait;
use Zrcms\ContentLanguage\Model\LanguageVersion;
use Zrcms\ContentLanguage\Model\LanguageVersionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_language_version",
 *     indexes={}
 * )
 */
class LanguageVersionEntity
    extends LanguageVersionAbstract
    implements LanguageVersion, ContentEntity
{
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
     * Three digit ISO 639-2/T "terminological" language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes
     *
     * @var string
     *
     * @ORM\Column(type="string", length=3)
     */
    protected $iso639_2t;

    /**
     * Three digit ISO 639-2/B "bibliographic" language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes
     *
     * @var string
     *
     * @ORM\Column(type="string", length=3)
     */
    protected $iso639_2b;

    /**
     * Two digit iso639_1 language code.
     *
     * @link http://en.wikipedia.org/wiki/List_of_ISO_639-2_codes
     *
     * @var string
     *
     * @ORM\Column(type="string", length=2)
     */
    protected $iso639_1;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

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
        $properties[PropertiesContent::ID] = Param::getInt(
            $properties,
            PropertiesContent::ID
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
}
