<?php

namespace Zrcms\CoreDoctrine\Site\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Core\Site\Model\SiteAbstract;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SitePublished extends SiteAbstract implements \Zrcms\Core\Site\Model\SitePublished
{
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
