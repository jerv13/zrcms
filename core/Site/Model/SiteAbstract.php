<?php

namespace Zrcms\Core\Site\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteAbstract implements Site
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
     * ISO3 Country code
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
