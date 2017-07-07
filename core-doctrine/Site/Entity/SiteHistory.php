<?php

namespace Zrcms\CoreDoctrine\Site\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Core\Site\Model\SiteAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SiteHistory extends SiteAbstract implements \Zrcms\Core\Site\Model\SiteHistory
{
    /**
     * @var int
     */
    protected $id;

    /**
     * Host name or domain name
     *
     * @var string
     */
    protected $host;

    /**
     * Theme name
     *
     * @var string
     */
    protected $theme;

    /**
     * Locale used for translations and formating
     *
     * @var string
     */
    protected $locale;

    /**
     *
     * @var array
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
