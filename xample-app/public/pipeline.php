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
    \Zrcms\HttpViewRender\Response\ResponseMutatorThemeLayoutWrapper::class
);

$app->pipe(
    \Zrcms\HttpRcmApiLib\Middleware\ResponseMutatorJsonRcmApiLibFormat::class
);

$app->pipe(
    \Zrcms\HttpStatusPages\Middleware\ResponseMutatorStatusPage::class
);

$app->pipe(ServerUrlMiddleware::class);

$app->pipe(
    \Zrcms\HttpSiteExists\Middleware\HttpSiteExists::class
);

$app->pipe(
    \Zrcms\HttpRedirect\Middleware\HttpContentRedirect::class
);
$app->pipe(
    \Zrcms\HttpLocale\Middleware\HttpLocaleFromSite::class
);
$app->pipe(
    \Zrcms\HttpUser\Middleware\HttpParamLogOut::class
);

$app->pipeRoutingMiddleware();
$app->pipe(ImplicitHeadMiddleware::class);
$app->pipe(ImplicitOptionsMiddleware::class);
$app->pipe(UrlHelperMiddleware::class);

$app->pipeDispatchMiddleware();

$app->pipe(
    \Zrcms\HttpViewRender\Request\RequestWithOriginalUri::class
);

$app->pipe(
    \Zrcms\HttpViewRender\Request\RequestWithView::class
);

$app->pipe(
    \Zrcms\PageAccess\Middleware\HttpPageAccessByView::class
);

$app->pipe(
    \Zrcms\HttpViewRender\Request\RequestWithViewRenderPage::class
);

$app->pipe(
    \Zrcms\HttpViewRender\FinalHandler\HttpNotFoundFinal::class
);
