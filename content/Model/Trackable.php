<?php

namespace Zrcms\Content\Model;

use Zrcms\Content\Exception\TrackingException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Trackable
{
    const UNKNOWN_USER_ID = 'unknown-user-id';
    const UNKNOWN_REASON = 'unknown-reason';
    const DATE_FORMAT = \DateTime::ISO8601;
    const DATE_FORMAT_TIMESTAMP = 'U';

    /**
     * @return string
     * @throws TrackingException
     */
    public function getCreatedDate(): string;

    /**
     * @return \DateTime
     */
    public function getCreatedDateObject(): \DateTime;

    /**
     * @return int
     * @throws TrackingException
     */
    public function getCreatedTimestamp(): int;

    /**
     * @return string
     * @throws TrackingException
     */
    public function getCreatedByUserId(): string;

    /**
     * @return string
     */
    public function getCreatedReason(): string;

    /**
     * @return bool
     */
    public function hasTrackingData();

    /**
     * @return void
     * @throws TrackingException
     */
    public function assertHasTrackingData();
}
