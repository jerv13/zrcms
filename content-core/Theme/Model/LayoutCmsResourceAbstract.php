<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutCmsResourceAbstract extends CmsResourceAbstract implements LayoutCmsResource
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
            PropertiesLayoutCmsResource::THEME_NAME,
            PropertyMissingException::build(
                PropertiesLayoutCmsResource::THEME_NAME,
                $properties,
                get_class($this)
            )
        );


        Param::assertHas(
            $properties,
            PropertiesLayoutCmsResource::NAME,
            PropertyMissingException::build(
                PropertiesLayoutCmsResource::NAME,
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
    public function getThemeName(): string
    {
        return $this->getProperty(
            PropertiesLayoutCmsResource::THEME_NAME,
            ''
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getProperty(
            PropertiesLayoutCmsResource::NAME,
            ''
        );
    }
}
