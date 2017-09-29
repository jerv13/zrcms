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
    \Zrcms\HttpExpressive\HttpRender\ResponseMutatorThemeLayoutWrapper::class
);

$app->pipe(
    \Zrcms\HttpExpressive\HttpApi\ResponseMutatorJsonRcmApiLibFormat::class
);

$app->pipe(
    \Zrcms\HttpExpressive\HttpRender\ResponseMutatorStatusPage::class
);

$app->pipe(ServerUrlMiddleware::class);

$app->pipe(
    \Zrcms\HttpExpressive\HttpAlways\SiteExists::class
);

$app->pipe(
    \Zrcms\HttpExpressive\HttpAlways\ContentRedirect::class
);
$app->pipe(
    \Zrcms\HttpExpressive\HttpAlways\LocaleFromSite::class
);
$app->pipe(
    \Zrcms\HttpExpressive\HttpAlways\ParamLogOut::class
);

$app->pipeRoutingMiddleware();
$app->pipe(ImplicitHeadMiddleware::class);
$app->pipe(ImplicitOptionsMiddleware::class);
$app->pipe(UrlHelperMiddleware::class);

$app->pipeDispatchMiddleware();

$app->pipe(
    \Zrcms\HttpExpressive\HttpAlways\RequestWithOriginalUri::class
);

$app->pipe(
    \Zrcms\HttpExpressive\HttpAlways\RequestWithView::class
);

$app->pipe(
    \Zrcms\HttpExpressive\HttpRender\Acl\IsAllowedToViewPage::class
);

$app->pipe(
    \Cart\Zrcms\HttpAlways\RequestWithViewProductPage::class
);

$app->pipe(
    \Zrcms\HttpExpressive\HttpAlways\RequestWithViewRenderPage::class
);

$app->pipe(
    \Zrcms\HttpExpressive\HttpRender\FinalHandler\NotFoundFinal::class
);

