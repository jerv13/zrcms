<?php

namespace Zrcms\ContentCore\Container\Model;

use Zrcms\Content\Exception\PropertyInvalid;
use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\ContentAbstract;
use Zrcms\ContentCore\Container\Api\BuildBlockVersions;
use Zrcms\ContentCore\Container\Fields\FieldsContainer;
use Zrcms\ContentCore\StringToHtmlClassName;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class ContainerAbstract extends ContentAbstract
{
    /**
     * @param array $properties
     *
     * @throws PropertyInvalid
     */
    public function __construct(array $properties)
    {
        $blockVersions = Param::getArray(
            $properties,
            FieldsContainer::BLOCK_VERSIONS,
            []
        );

        $properties[FieldsContainer::BLOCK_VERSIONS] = BuildBlockVersions::prepare(
            $blockVersions
        );

        $this->assertValidProperties($properties);

        parent::__construct($properties);
    }

    /**
     * @return array
     */
    public function getBlockVersions(): array
    {
        $blockVersions = $this->getProperty(
            FieldsContainer::BLOCK_VERSIONS,
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
            FieldsContainer::HTML_NAME,
            PropertyMissing::buildThrower(
                FieldsContainer::HTML_NAME,
                $properties,
                get_class($this)
            )
        );

        $htmlName = $properties[FieldsContainer::HTML_NAME];
        $validHtmlName = StringToHtmlClassName::invoke($htmlName);

        if ($htmlName !== $validHtmlName) {
            throw new PropertyInvalid(
                'Property (' . FieldsContainer::HTML_NAME . ') must be in valid format:'
                . ' expected: (' . $validHtmlName . ')'
                . ' got: (' . $htmlName . ')'
            );
        }
    }
}
