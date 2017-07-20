<?php

namespace Zrcms\Content\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface CmsResource extends Immutable ,Properties
{
    /**
     * @param string $contentRevisionId
     * @param array  $properties
     */
    public function __construct(
        string $contentRevisionId,
        array $properties = []
    );

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getContentRevisionId(): string;
}
