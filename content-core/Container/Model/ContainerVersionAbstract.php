<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Exception\PropertyInvalid;
use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\ContentVersionAbstract;
use Zrcms\ContentCore\Container\Api\BuildBlockVersions;
use Zrcms\ContentCore\Container\Fields\FieldsContainerVersion;
use Zrcms\ContentCore\StringToHtmlClassName;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerVersionAbstract extends ContentVersionAbstract
{
    /**
     * @param null|string $id
     * @param array       $properties
     * @param string      $createdByUserId
     * @param string      $createdReason
     *
     * @throws PropertyInvalid
     */
    public function __construct(
        $id,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $blockVersions = Param::getArray(
            $properties,
            FieldsContainerVersion::BLOCK_VERSIONS,
            []
        );

        $properties[FieldsContainerVersion::BLOCK_VERSIONS] = BuildBlockVersions::prepare(
            $blockVersions
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
     * @return array
     */
    public function getBlockVersions(): array
    {
        $blockVersions = $this->getProperty(
            FieldsContainerVersion::BLOCK_VERSIONS,
            []
        );

        /** @var ContainerVersion $containerVersion */
        $containerVersion = $this;

        return BuildBlockVersions::invoke(
            $containerVersion,
            $blockVersions
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
            FieldsContainerVersion::HTML_NAME,
            PropertyMissing::buildThrower(
                FieldsContainerVersion::HTML_NAME,
                $properties,
                get_class($this)
            )
        );

        $htmlName = $properties[FieldsContainerVersion::HTML_NAME];
        $validHtmlName = StringToHtmlClassName::invoke($htmlName);

        if ($htmlName !== $validHtmlName) {
            throw new PropertyInvalid(
                'Property (' . FieldsContainerVersion::HTML_NAME . ') must be in valid format:'
                . ' expected: (' . $validHtmlName . ')'
                . ' got: (' . $htmlName . ')'
            );
        }
    }
}
