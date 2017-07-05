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
     * @var string domain name
     */
    protected $domain;

    /**
     * @var string
     */
    protected $local;

    /**
     * @var array
     */
    protected $data = [];
}
