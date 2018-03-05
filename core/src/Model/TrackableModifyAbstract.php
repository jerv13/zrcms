<?php

namespace Zrcms\Core\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class TrackableModifyAbstract extends TrackableAbstract implements Trackable
{
    use TrackableModifyTrait;

    /**
     * @param string $createdByUserId
     * @param string $createdReason
     * @param null   $createdDate
     *
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __construct(
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        $this->setModifiedData(
            $createdByUserId,
            $createdReason,
            $createdDate
        );

        parent::__construct(
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }
}
