<?php

namespace Zrcms\Core\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class TrackableAbstract implements Trackable
{
    use TrackableTrait;

    /**
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     *
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __construct(
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        $this->setCreatedData(
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }
}
