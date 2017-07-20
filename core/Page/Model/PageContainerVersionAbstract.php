<?php

namespace Zrcms\Core\Page\Model;

use Zrcms\Core\Container\Model\ContainerVersionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageContainerVersionAbstract
    extends ContainerVersionAbstract
    implements PageContainerVersion
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
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
            PropertiesPageContainerVersion::TITLE
        );

        $this->keywords = Param::getRequired(
            $properties,
            PropertiesPageContainerVersion::KEYWORDS
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
