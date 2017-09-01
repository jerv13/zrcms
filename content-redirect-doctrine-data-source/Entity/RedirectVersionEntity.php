<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Model\PropertiesContent;
use Zrcms\ContentRedirect\Model\PropertiesRedirectVersion;
use Zrcms\ContentRedirect\Model\RedirectVersion;
use Zrcms\ContentRedirect\Model\RedirectVersionAbstract;
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
     * Theme name
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $redirectPath;

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

        $this->redirectPath = Param::getString(
            $properties,
            PropertiesRedirectVersion::REDIRECT_PATH
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getRedirectPath(): string
    {
        return $this->redirectPath;
    }
}
