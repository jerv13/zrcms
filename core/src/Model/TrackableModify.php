<?php

namespace Zrcms\Core\Model;

use Zrcms\Core\Exception\TrackingInvalid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface TrackableModify extends Trackable
{
    /**
     * @return string
     * @throws TrackingInvalid
     */
    public function getModifiedDate(): string;

    /**
     * @return \DateTime
     */
    public function getModifiedDateObject(): \DateTime;

    /**
     * @return int
     * @throws TrackingInvalid
     */
    public function getModifiedTimestamp(): int;

    /**
     * @return string
     * @throws TrackingInvalid
     */
    public function getModifiedByUserId(): string;

    /**
     * @return string
     */
    public function getModifiedReason(): string;

    /**
     * @return bool
     */
    public function hasModifiedData();

    /**
     * @return void
     * @throws TrackingInvalid
     */
    public function assertHasModifiedData();
}
