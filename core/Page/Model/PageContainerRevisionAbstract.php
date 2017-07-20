<?php

namespace Zrcms\Core\Page\Model;

use Zrcms\Core\Container\Model\ContainerRevisionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageContainerRevisionAbstract extends ContainerRevisionAbstract implements PageContainerRevision
{
    protected $title;

    protected $keywords;

    /**
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->title = Param::getRequired(
            $properties,
            PageContainerRevisionProperties::TITLE
        );

        $this->keywords = Param::getRequired(
            $properties,
            PageContainerRevisionProperties::KEYWORDS
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }
}
