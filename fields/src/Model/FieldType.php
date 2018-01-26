<?php

namespace Zrcms\Fields\Model;

use Zrcms\Core\Model\Properties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FieldType extends Properties
{
    const DEFAULT_TYPE = 'text';

    /**
     * @param string $type
     * @param array  $properties
     */
    public function __construct(
        string $type,
        array $properties
    );

    /**
     * @return string
     */
    public function getType():string;
}
