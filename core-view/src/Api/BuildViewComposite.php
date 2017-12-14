<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Model\View;

/**
 * @todo   This may NOT be needed
 *
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewComposite implements BuildView
{
    /**
     * @todo viewBuilders should come from a View component
     * @var array
     */
    protected $viewBuilders = [];

    /**
     * @param array $viewBuilders
     *
     * @return void
     */
    public function addMulti(array $viewBuilders)
    {
        foreach ($viewBuilders as $viewBuilder) {
            $this->add($viewBuilder);
        }
    }

    /**
     * @param BuildView $viewBuilder
     *
     * @return void
     */
    public function add(BuildView $viewBuilder)
    {
        $this->viewBuilders[] = $viewBuilder;
    }

    /**
     * @param ServerRequestInterface $request
     * @param View                   $view
     * @param array                  $options
     *
     * @return View
     */
    public function __invoke(
        ServerRequestInterface $request,
        View $view,
        array $options = []
    ): View {
        /** @var BuildView $viewBuilder */
        foreach ($this->viewBuilders as $viewBuilder) {
            $view = $viewBuilder->__invoke(
                $request,
                $view,
                $options
            );
        }

        return $view;
    }
}
