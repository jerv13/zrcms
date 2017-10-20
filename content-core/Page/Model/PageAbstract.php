<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Exception\PropertyInvalid;
use Zrcms\Content\Exception\PropertyMissing;
use Zrcms\Content\Model\ContentAbstract;
use Zrcms\ContentCore\Page\Fields\FieldsPage;
use Zrcms\ContentCore\StringToHtmlClassName;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PageAbstract extends ContentAbstract
{
    /**
     * @param array $properties
     */
    public function __construct(
        array $properties
    ) {
        Param::assertHas(
            $properties,
            FieldsPage::TITLE,
            PropertyMissing::buildThrower(
                FieldsPage::TITLE,
                $properties,
                get_class($this)
            )
        );

        Param::assertHas(
            $properties,
            FieldsPage::KEYWORDS,
            PropertyMissing::buildThrower(
                FieldsPage::KEYWORDS,
                $properties,
                get_class($this)
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
        return $this->getProperty(
            FieldsPage::TITLE,
            ''
        );
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getProperty(
            FieldsPage::DESCRIPTION,
            ''
        );
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->getProperty(
            FieldsPage::KEYWORDS,
            ''
        );
    }
}
