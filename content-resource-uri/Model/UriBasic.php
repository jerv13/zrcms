<?php

namespace Zrcms\ContentResourceUri\Model;

use Zrcms\ContentResourceUri\Schema\UriSchemaBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UriBasic implements Uri
{
    protected $siteId;
    protected $type;
    protected $path;

    /**
     * @param string $siteId
     * @param string $type
     * @param string $path
     */
    public function __construct(
        string $siteId,
        string $type,
        string $path
    ) {
        $this->siteId = $siteId;
        $this->type = $type;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getSiteId(): string
    {
        return $this->siteId;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getSchema(): string
    {
        return UriSchemaBasic::SCHEMA;
    }
}
