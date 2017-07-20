<?php

namespace Zrcms\Core\Site\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class SiteCmsResourceAbstract extends CmsResourceAbstract implements SiteCmsResource
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @param string $contentRevisionId
     * @param array  $properties
     */
    public function __construct(
        string $contentRevisionId,
        array $properties = []
    ) {
        $this->host = Param::getAndRemoveRequired(
            $properties,
            SiteCmsResourceProperties::HOST,
            new PropertyMissingException(
                'Required property (' . SiteCmsResourceProperties::HOST . ') is missing in: '
                . get_class($this)
            )
        );

        parent::__construct(
            $contentRevisionId,
            $properties
        );
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }
}
