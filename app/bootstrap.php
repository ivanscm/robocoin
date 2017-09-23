<?php
declare(strict_types = 1);
use Nette\Application\Routers\SimpleRouter;

if (@!include __DIR__ . '/../vendor/autoload.php') {
    die('Install Nette using `composer update`');
}

$debugMode = isset($_SERVER['WEB_DEBUG_MODE']) ? (bool)$_SERVER['WEB_DEBUG_MODE'] : false;

$configurator = new Nette\Configurator;

$configurator->setDebugMode($debugMode);

$configurator->enableTracy(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
    ->addDirectory(__DIR__)
    ->register();

$configurator->addConfig(__DIR__ . '/config.neon');
$container = $configurator->createContainer();
$container->addService('router', new SimpleRouter('Default:default'));
return $container;