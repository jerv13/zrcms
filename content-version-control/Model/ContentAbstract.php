<?php

namespace Zrcms\ContentVersionControl\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContentAbstract implements Content
{
    use TrackableTrait;
    use ContentTrait;

    /**
     * @param string $uri
     * @param string $sourceUri
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $uri,
        string $sourceUri,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        // Immutable: Don't let the construct be called, if values are set
        if ($this->hasTrackingData()) {
            return;
        }

        $this->properties = $properties;
        $this->setCreatedData(
            $createdByUserId,
            $createdReason
        );
    }
}
