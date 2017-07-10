<?php

namespace Zrcms\Core\Uri\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class UriBasic implements Uri
{
    protected $siteId;
    protected $type;
    protected $path;
    protected $schema = Uri::SCHEMA;

    /**
     * @param string $siteId
     * @param string $type
     * @param string $path
     * @param string $schema
     */
    public function __construct(
        string $siteId,
        string $type,
        string $path,
        string $schema = Uri::SCHEMA
    ) {
        $this->siteId = $siteId;
        $this->type = $type;
        $this->path = $path;
        $this->schema = $schema;
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
        return $this->schema;
    }
}
