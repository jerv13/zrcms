<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\ContentCore\Container\Model\ContainerVersionAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageContainerVersionAbstract
    extends ContainerVersionAbstract
    implements PageContainerVersion
{
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
        Param::assertHas(
            $properties,
            PropertiesPageContainerVersion::TITLE,
            PropertyMissingException::build(
                PropertiesPageContainerVersion::TITLE,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            PropertiesPageContainerVersion::KEYWORDS,
            PropertyMissingException::build(
                PropertiesPageContainerVersion::KEYWORDS,
                $properties,
                get_class($this)
            )
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
        return $this->getProperty(
            PropertiesPageContainerVersion::TITLE,
            ''
        );
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->getProperty(
            PropertiesPageContainerVersion::KEYWORDS,
            ''
        );
    }
}
