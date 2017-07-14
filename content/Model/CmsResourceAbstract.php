<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class CmsResourceAbstract implements CmsResource
{
    use TrackableTrait;

    protected $uri;
    protected $source;
    protected $content;

    /**
     * @param string  $uri
     * @param string  $source
     * @param Content $content
     * @param string  $createdByUserId
     * @param string  $createdReason
     */
    public function __construct(
        string $uri,
        string $source,
        Content $content,
        string $createdByUserId,
        string $createdReason
    ) {
        // Enforce immutability
        if ($this->hasTrackingData()) {
            return;
        }

        $this->uri = $uri;
        $this->source = $source;
        $this->content = $content;

        $this->setCreatedData(
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * Unique URI
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Creation source
     *
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return Content
     */
    public function getContent(): Content
    {
        return $this->content;
    }
}
