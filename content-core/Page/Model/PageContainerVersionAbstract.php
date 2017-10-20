<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Exception\PropertyInvalid;
use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\ContentCore\Container\Model\ContainerVersionAbstract;
use Zrcms\ContentCore\Page\Fields\FieldsPageContainerVersion;
use Zrcms\ContentCore\StringToHtmlClassName;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageContainerVersionAbstract extends ContainerVersionAbstract
{
    /**
     * @param string|null $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        Param::assertHas(
            $properties,
            FieldsPageContainerVersion::TITLE,
            PropertyMissing::buildThrower(
                FieldsPageContainerVersion::TITLE,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            FieldsPageContainerVersion::KEYWORDS,
            PropertyMissing::buildThrower(
                FieldsPageContainerVersion::KEYWORDS,
                $properties,
                get_class($this)
            )
        );

        $this->assertValidProperties($properties);

        parent::__construct(
            $id,
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
            FieldsPageContainerVersion::TITLE,
            ''
        );
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getProperty(
            FieldsPageContainerVersion::DESCRIPTION,
            ''
        );
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->getProperty(
            FieldsPageContainerVersion::KEYWORDS,
            ''
        );
    }

    /**
     * @param array $properties
     *
     * @return void
     * @throws PropertyInvalid
     */
    public function assertValidProperties(array $properties)
    {
        Param::assertNotEmpty(
            $properties,
            FieldsPageContainerVersion::HTML_NAME,
            PropertyMissing::buildThrower(
                FieldsPageContainerVersion::HTML_NAME,
                $properties,
                get_class($this)
            )
        );

        $htmlName = $properties[FieldsPageContainerVersion::HTML_NAME];
        $validHtmlName = StringToHtmlClassName::invoke($htmlName);

        if ($htmlName !== $validHtmlName) {
            throw new PropertyInvalid(
                'Property (' . FieldsPageContainerVersion::HTML_NAME . ') must be in valid format:'
                . ' expected: (' . $validHtmlName . ')'
                . ' got: (' . $htmlName . ')'
            );
        }
    }
}
