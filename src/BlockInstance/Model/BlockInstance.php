<?php

namespace Rcms\Core\BlockInstance\Model;


/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockInstance
{
    /**
     * @return mixed
     */
    public function getId(): int;

    /**
     * @return mixed
     */
    public function getName(): string;

    /**
     * @return array The instance config for this block instance. This is what admins can edit in the CMS
     */
    public function getConfig(): array;

    /**
     * @return mixed
     */
    public function getConfigValue(string $name, $default = null);
}
