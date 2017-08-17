<?php

namespace Zrcms\HttpRedirectDoctrineDataSource\Redirect\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Model\PropertiesContent;
use Zrcms\HttpRedirect\Redirect\Model\PropertiesRedirectVersion;
use Zrcms\HttpRedirect\Redirect\Model\RedirectVersion;
use Zrcms\HttpRedirect\Redirect\Model\RedirectVersionAbstract;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\ContentDoctrine\Entity\ContentEntityTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_redirect_version",
 *     indexes={}
 * )
 */
class RedirectVersionEntity
    extends RedirectVersionAbstract
    implements RedirectVersion, ContentEntity
{
    use ContentEntityTrait;

    /**
     * @var string
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
     * Theme name
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $themeName;

    /**
     * Locale used for translations and formatting
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $locale;

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
            PropertiesRedirectVersion::ID
        );

        $this->themeName = Param::getString(
            $properties,
            PropertiesRedirectVersion::THEME_NAME
        );

        $this->locale = Param::getString(
            $properties,
            PropertiesRedirectVersion::LOCALE
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
}
