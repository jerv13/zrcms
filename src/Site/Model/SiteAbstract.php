<?php

namespace Rcms\Core\Site\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteAbstract
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string host name or domain name
     */
    protected $host;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var array
     */
    protected $properties = [];
}
