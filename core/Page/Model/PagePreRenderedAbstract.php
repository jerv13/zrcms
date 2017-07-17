<?php

namespace Zrcms\Core\Page\Model;

use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class PagePreRenderedAbstract extends PageAbstract implements PagePreRendered
{
    protected $html;

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
        $this->html = Param::getRequired(
            $properties,
            PageProperties::PRE_RENDERED_HTML
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
    public function getHtml(): string
    {
        return $this->html;
    }
}
