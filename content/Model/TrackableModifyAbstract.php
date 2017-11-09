<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class TrackableModifyAbstract extends TrackableAbstract implements Trackable
{
    use TrackableModifyTrait;

    /**
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     */
    public function __construct(
        string $createdByUserId,
        string $createdReason,
        string $createdDate = null
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
