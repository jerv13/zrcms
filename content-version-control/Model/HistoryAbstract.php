<?php

namespace Zrcms\ContentVersionControl\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HistoryAbstract extends ContentAbstract implements History
{
    /**
     * @var string
     */
    protected $action;

    /**
     * @param string $uri
     * @param string $sourceUri
     * @param string $action
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        string $uri,
        string $sourceUri,
        string $action,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->action = $action;

        parent::__construct(
            $uri,
            $sourceUri,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }
}
