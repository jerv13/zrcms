<?php

namespace Zrcms\Core\Theme\Model;

use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\Content\Model\CmsResourceAbstract;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class LayoutCmsResourceAbstract extends CmsResourceAbstract implements LayoutCmsResource
{
    /**
     * @var string
     */
    protected $themeName;

    /**
     * @var string
     */
    protected $name;

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
        // @todo might use getAndRemoveRequired
        $this->themeName = Param::getRequired(
            $properties,
            PropertiesLayoutCmsResource::THEME_NAME,
            new PropertyMissingException(
                'Required property (' . PropertiesLayoutCmsResource::THEME_NAME . ') is missing in: ' . get_class($this)
            )
        );

        // @todo might use getAndRemoveRequired
        $this->name = Param::getRequired(
            $properties,
            PropertiesLayoutCmsResource::NAME,
            new PropertyMissingException(
                'Required property (' . PropertiesLayoutCmsResource::NAME . ') is missing in: ' . get_class($this)
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
        return $this->themeName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
