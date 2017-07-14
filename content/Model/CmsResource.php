<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResource extends Trackable
{
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
    );

    /**
     * Unique URI
     *
     * @return string
     */
    public function getUri(): string;

    /**
     * Creation source
     *
     * @return string
     */
    public function getSource(): string;

    /**
     * @return Content
     */
    public function getContent(): Content;
}
