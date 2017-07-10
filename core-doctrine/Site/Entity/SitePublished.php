<?php

namespace Zrcms\CoreDoctrine\Site\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Core\Site\Model\SiteAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_site_published",
 *     indexes={
 *         @ORM\Index(name="uid_index", columns={"uid"})
 *     }
 * )
 */
class SitePublished extends SiteAbstract implements \Zrcms\Core\Site\Model\SitePublished
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    protected $uid;

    /**
     * Host name or domain name
     *
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $host;

    /**
     * Theme name
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $theme;

    /**
     * Locale used for translations and formating
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $locale;

    /**
     *
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $properties = [];

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
