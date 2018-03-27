<?php

namespace Zrcms\CoreSiteContainer\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class SiteContainerVersionBasic extends SiteContainerVersionAbstract implements SiteContainerVersion
{
    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     *
     * @throws \Exception
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     * @throws \Throwable
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
}
