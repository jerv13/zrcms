<?php
/**
 * import.php
 */
/* auto-loader */
require __DIR__ . '/../../../../autoload.php';

/** @var \Psr\Container\ContainerInterface $serviceContainer */
$serviceContainer = require __DIR__ . '/../../../../../config/container.php';

$factory = new \Zrcms\Importer\Api\ImportFactory();

$import = $factory->__invoke($serviceContainer);

if (!isset($argv[1])) {
    echo 'File to import is required as arg 1';
    exit(1);
}

$createdByUserId = 'cli-import';

$file = realpath($argv[1]);

if (!file_exists($file)) {
    echo 'File to import not found ' . $file;
    exit(1);
}

$contents = file_get_contents($file);

$import->__invoke(
    $contents,
    $createdByUserId
);
