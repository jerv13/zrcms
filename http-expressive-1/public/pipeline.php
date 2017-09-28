<?php

use Zend\Expressive\Helper\ServerUrlMiddleware;
use Zend\Expressive\Helper\UrlHelperMiddleware;
use Zend\Expressive\Middleware\ImplicitHeadMiddleware;
use Zend\Expressive\Middleware\ImplicitOptionsMiddleware;

/**
 * Setup middleware pipeline:
 *
 * @var \Zend\Expressive\Application $app
 */
$app->pipe(
    \Zrcms\HttpExpressive1\HttpRender\ResponseMutatorThemeLayoutWrapper::class
);

$app->pipe(
    \Zrcms\HttpExpressive1\HttpApi\ResponseMutatorJsonRcmApiLibFormat::class
);

$app->pipe(
    \Zrcms\HttpExpressive1\HttpRender\ResponseMutatorStatusPage::class
);

$app->pipe(ServerUrlMiddleware::class);

$app->pipe(
    \Zrcms\HttpExpressive1\HttpAlways\SiteExists::class
);

$app->pipe(
    \Zrcms\HttpExpressive1\HttpAlways\ContentRedirect::class
);
$app->pipe(
    \Zrcms\HttpExpressive1\HttpAlways\LocaleFromSite::class
);
$app->pipe(
    \Zrcms\HttpExpressive1\HttpAlways\ParamLogOut::class
);

$app->pipeRoutingMiddleware();
$app->pipe(ImplicitHeadMiddleware::class);
$app->pipe(ImplicitOptionsMiddleware::class);
$app->pipe(UrlHelperMiddleware::class);

$app->pipeDispatchMiddleware();

$app->pipe(
    \Zrcms\HttpExpressive1\HttpAlways\RequestWithOriginalUri::class
);

$app->pipe(
    \Zrcms\HttpExpressive1\HttpAlways\RequestWithView::class
);

$app->pipe(
    \Zrcms\HttpExpressive1\HttpRender\Acl\IsAllowedToViewPage::class
);

$app->pipe(
    \Cart\Zrcms\HttpAlways\RequestWithViewProductPage::class
);

$app->pipe(
    \Zrcms\HttpExpressive1\HttpAlways\RequestWithViewRenderPage::class
);

$app->pipe(
    \Zrcms\HttpExpressive1\HttpRender\FinalHandler\NotFoundFinal::class
);

