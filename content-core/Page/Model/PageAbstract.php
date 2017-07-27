<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\ContentAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageAbstract extends ContentAbstract implements Page
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
     */
    public function __construct(
        array $properties
    ) {
        $this->title = Param::getRequired(
            $properties,
            PropertiesPageContainerVersion::TITLE,
            new PropertyMissingException(
                'Required property (' . PropertiesPageContainerVersion::TITLE . ') is missing in: '
                . get_class($this)
            )
        );

        $this->keywords = Param::getRequired(
            $properties,
            PropertiesPageContainerVersion::KEYWORDS,
            new PropertyMissingException(
                'Required property (' . PropertiesPageContainerVersion::KEYWORDS . ') is missing in: '
                . get_class($this)
            )
        );

        parent::__construct(
            $properties
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
