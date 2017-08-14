<?php

namespace Zrcms\HttpExpressive1\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestedPage
{
    const PROPERTY_NAME = 'zrcms-requested-page-path';

    protected $name;
    protected $revision;
    protected $type;

    /**
     * @param string $name
     * @param string $revision
     * @param string $type
     */
    public function __construct(
        $name,
        $revision,
        $type = 'n' //BC
    )
    {
        $this->name = $name;
        $this->revision = $revision;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return get_object_vars($this);
    }
}
