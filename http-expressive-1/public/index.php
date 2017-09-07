<?php

chdir(dirname(__DIR__));
require __DIR__ . '/../../../../autoload.php';

$env = getenv('ENV');
if (!$env) {
    $env = 'local';
}
\Reliv\Server\Environment::buildInstance(__DIR__ . '/../config/_server-environment', $env);

/** @var \Psr\Container\ContainerInterface $serviceContainer */
$serviceContainer = require __DIR__ . '/../../../../../config/container.php';

/** @var \Zend\Expressive\Application $app */
$app = $container->get(\Zrcms\HttpExpressive1\ApplicationZrcms::class);

$app->run();
