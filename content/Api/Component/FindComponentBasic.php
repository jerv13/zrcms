<?php

namespace Zrcms\Content\Api\Component;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindComponentBasic extends FindComponentAbstract implements FindComponent
{
    /**
     * @param GetRegisterComponents $getRegisterComponents
     * @param SearchComponentList   $searchComponentList
     */
    public function __construct(
        GetRegisterComponents $getRegisterComponents,
        SearchComponentList $searchComponentList
    ) {
        parent::__construct(
            $getRegisterComponents,
            $searchComponentList
        );
    }
}
