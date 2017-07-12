<?php

namespace Zrcms\ContentVersionControl\Model;

use Zrcms\ContentVersionControl\Exception\TrackingException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface Trackable
{
    const UNKNOWN_USER_ID = 'unknown';
    const UNKNOWN_REASON = 'unknown';

    /**
     * @return \DateTime
     * @throws TrackingException
     */
    public function getCreatedDate(): \DateTime;

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
