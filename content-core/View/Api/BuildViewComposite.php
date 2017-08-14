<?php

namespace Zrcms\ContentCore\View\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildViewComposite implements BuildView
{
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
    ): View
    {
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
